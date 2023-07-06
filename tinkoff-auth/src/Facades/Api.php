<?php

namespace TinkoffAuth\Facades;

use TinkoffAuth\Config\Api as ApiConfig;
use TinkoffAuth\Config\Auth;
use TinkoffAuth\Helpers\ApiFormatter;
use TinkoffAuth\Helpers\ApiHelper;
use TinkoffAuth\Services\Http\Request;
use TinkoffAuth\Services\Logger\RequestLogger;
use TinkoffAuth\Services\State\State;

/**
 * Фасад для работы с API
 */
class Api extends BaseFacade
{
    /**
     * Необходимые scopes для получения профиля пользователя
     */
    const SCOPES_FOR_AUTH = [
        'phone'
    ];

    /**
     * Получение AccessToken. Обертка над $this->token()
     *
     * @param bool $validateState Проверить ли state
     *
     * @return string|null
     */
    public function getAccessToken($validateState = true)
    {
        $token = $this->token($validateState);

        return isset($token['access_token']) && $token['access_token'] ? $token['access_token'] : null;
    }

    /**
     * Получение AccessToken через RefreshToken. Обертка updateToken
     *
     * @param string $refreshToken
     *
     * @return string|null
     */
    public function updateAccessToken($refreshToken)
    {
        $token = $this->updateToken($refreshToken);

        return isset($token['access_token']) && $token['access_token'] ? $token['access_token'] : null;
    }

    /**
     * Получение scopes. Обертка над $this->introspect()
     *
     * @param string|null $accessToken Access Token полученный раннее
     * @param bool $useConfig Использовать ли конфиг для получения данных
     *
     * @return array
     */
    public function getScopes($accessToken = null, $useConfig = true)
    {
        $apiConfig = ApiConfig::getInstance();

        $scope = $apiConfig->get(ApiConfig::USER_SCOPES);
        if ($useConfig && $scope) {
            return $scope;
        }

        $scope = $this->introspect($accessToken)['scope'];

        if ($useConfig) {
            $apiConfig->push(ApiConfig::USER_SCOPES, $scope);
        }

        return $scope;
    }

    /**
     * Проверка scopes
     *
     * @param array $scopeForCompare
     * @param string|null $accessToken Access Token полученный раннее
     *
     * @return bool
     */
    public function validateScopes($scopeForCompare = [], $accessToken = null)
    {
        $userScopes = $this->getScopes($accessToken);

        return ApiHelper::validateScopes($userScopes, $scopeForCompare);
    }

    /**
     * Запрос для получения Access Token
     *
     * @param bool $validateState Нужно ли проверять State
     *
     * @return array
     */
    public function token($validateState = true)
    {
        $authConfig = Auth::getInstance();

        $authParams = $this->getAuthParams($validateState);
        $code       = isset($authParams['code']) && $authParams['code'] ? $authParams['code'] : null;

        if (!$code) {
            return [];
        }

        $query    = [
            'grant_type'   => 'authorization_code',
            'code'         => $code,
            'redirect_uri' => $authConfig->get(Auth::REDIRECT_URI)
        ];
        $request  = $this->createTinkoffIDRequest();
        $response = $request->post('/auth/token', $query);

        RequestLogger::request('POST', 'https://id.tinkoff.ru/auth/token', $query, $response);

        return ApiFormatter::formatTokenParams($response);
    }

    /**
     * Запрос для получения Access Token через RefreshToken
     *
     * @param $refreshToken
     *
     * @return array
     */
    public function updateToken($refreshToken)
    {
        $authConfig = Auth::getInstance();

        $request = $this->createTinkoffIDRequest();

        $query    = [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
            'redirect_uri'  => $authConfig->get(Auth::REDIRECT_URI)
        ];
        $response = $request->post('/auth/token', $query);

        RequestLogger::request('POST', 'https://id.tinkoff.ru/auth/token', $query, $response);

        return ApiFormatter::formatTokenParams($response);
    }

    /**
     * Запрос на получение данных пользователя
     *
     * @param $accessToken
     *
     * @return array
     */
    public function userinfo($accessToken = null)
    {
        $authConfig = Auth::getInstance();

        $request = $this->createTinkoffIDBearerRequest($accessToken);

        $query    = [
            'client_id'     => $authConfig->get(Auth::CLIENT_ID),
            'client_secret' => $authConfig->get(Auth::CLIENT_SECRET)
        ];
        $response = $request->post('/userinfo/userinfo', $query);

        RequestLogger::request('POST', 'https://id.tinkoff.ru/userinfo/userinfo', $query, $response);
        return $response->json();
    }

    /**
     * Получение максимально возможной информации о пользователе
     *
     * @param string|null $accessToken
     *
     * @return array
     */
    public function userinfoFull($accessToken = null)
    {
        $authConfig = Auth::getInstance();
        $apiConfig  = ApiConfig::getInstance();

        $accessToken = isset($accessToken) && $accessToken ? $accessToken : $authConfig->get(Auth::ACCESS_TOKEN);
        if (!$accessToken) {
            return ApiFormatter::formatUserinfoFull();
        }

        $routes       = $apiConfig->getScopesURLs();
        $neededScopes = $apiConfig->getScopes();

        $userinfoFull = [];
        foreach ($routes as $scopeIndex => $route) {
            $scopes = isset($neededScopes[$scopeIndex]) && $neededScopes[$scopeIndex] ? $neededScopes[$scopeIndex] : [];

            $userHasNeededScopes = $this->validateScopes($scopes);
            if (!$userHasNeededScopes) {
                continue;
            }

            $request = new Request();
            $request = $this->addBearerCredentials($request, $accessToken);

            $query  = [];
            $method = 'GET';
            switch ($scopeIndex) {
                case ApiConfig::SCOPES_USERINFO:
                    $query    = [
                        'client_id'     => $authConfig->get(Auth::CLIENT_ID),
                        'client_secret' => $authConfig->get(Auth::CLIENT_SECRET)
                    ];
                    $response = $request->post($route, $query);
                    $method   = 'POST';
                    break;
                default:
                    $response = $request->request($route);
            }

            RequestLogger::request($method, $route, $query, $response);

            $userinfoFull[$scopeIndex] = $response->json();
        }

        return ApiFormatter::formatUserinfoFull($userinfoFull);
    }

    /**
     * Запрос на получение предоставленных данных пользователем
     *
     * @param string|null $accessToken Access Token полученный раннее
     *
     * @return array
     */
    public function introspect($accessToken = null)
    {
        if (!$accessToken) {
            $authConfig  = Auth::getInstance();
            $accessToken = $authConfig->get(Auth::ACCESS_TOKEN);
        }

        $query = ['token' => $accessToken,];
        $request  = $this->createTinkoffIDRequest();
        $response = $request->post('/auth/introspect', $query);

        RequestLogger::request('POST', 'https://id.tinkoff.ru/auth/introspect', $query, $response);

        return ApiFormatter::formatIntrospectParams($response);
    }


    /**
     * Получение параметров авторизации для auth/complete роута
     *
     * @param bool $validateState
     *
     * @return array
     */
    public function getAuthParams($validateState = true)
    {
        $state        = isset($_GET['state']) && $_GET['state'] ? $_GET['state'] : -1;
        $stateSession = isset($_GET['session_state']) && $_GET['session_state'] ? $_GET['session_state'] : -1;
        $code         = isset($_GET['code']) && $_GET['code'] ? $_GET['code'] : null;

        if ($validateState) {
            $stateService = new State();
            if (!$stateService->validate($state)) {
                return [];
            }
        }

        return [
            'state'         => $state,
            'session_state' => $stateSession,
            'code'          => $code
        ];
    }

    /**
     * Добавление Base авторизации запросу к client_id и client_secret
     *
     * @param Request $request
     *
     * @return Request
     */
    public function addBaseAuthCredentials($request)
    {
        $authConfig = Auth::getInstance();

        $username = $authConfig->getUsername();
        $password = $authConfig->getPassword();

        $request->basic($username, $password);

        return $request;
    }

    /**
     * Добавление Bearer авторизации с Access Token
     *
     * @param Request $request
     * @param $accessToken
     *
     * @return Request
     */
    public function addBearerCredentials($request, $accessToken = null)
    {
        $authConfig = Auth::getInstance();

        if (!$accessToken) {
            $accessToken = $authConfig->get(Auth::ACCESS_TOKEN);
        }

        $request->bearer($accessToken);

        return $request;
    }

    /**
     * Создание запроса https://id.tinkoff.ru с Base авторизацией
     *
     * @return Request
     */
    private function createTinkoffIDRequest()
    {
        $request = new Request('https://id.tinkoff.ru/');

        return $this->addBaseAuthCredentials($request);
    }

    /**
     * Создание запроса https://id.tinkoff.ru с Bearer авторизацией. Для получения данных пользовтаеля
     *
     * @param $accessToken
     *
     * @return Request
     */
    private function createTinkoffIDBearerRequest($accessToken = null)
    {
        $request = new Request('https://id.tinkoff.ru/');

        return $this->addBearerCredentials($request, $accessToken);
    }
}