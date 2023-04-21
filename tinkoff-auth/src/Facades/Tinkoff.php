<?php

namespace TinkoffAuth\Facades;

use TinkoffAuth\Config\Api as ApiConfig;
use TinkoffAuth\Config\Auth;
use TinkoffAuth\Exceptions\UnknownConfig;
use TinkoffAuth\Mediator\FunctionMediator;
use TinkoffAuth\Services\State\State;

/**
 * Основной фасад для быстрой авторизации пользователя
 */
class Tinkoff extends BaseFacade
{
    /**
     * Получение ссылки на авторизацию
     *
     * @param string|null $redirectURI
     * @param array $scopeParameters
     *
     * @return string
     */
    public function getAuthURL($redirectURI = null, $scopeParameters = [])
    {
        $authConfig = Auth::getInstance();
        if ( ! $redirectURI) {
            $redirectURI = $authConfig->get(Auth::REDIRECT_URI);
        }

        $state = new State();

        $baseURL = 'https://id.tinkoff.ru/auth/authorize?';
        $query   = [
            'client_id'     => $authConfig->get(Auth::CLIENT_ID),
            'redirect_uri'  => $redirectURI,
            'state'         => $state->getState(),
            'response_type' => 'code'
        ];

        if ( ! empty($scopeParameters)) {
            $query['scope_parameters'] = json_encode($scopeParameters);
        }

        return $baseURL . http_build_query($query);
    }

    /**
     * Авторизация пользователя и возвращение его данных по возможности
     *
     * @return FunctionMediator Промежуточный объект, для получения информации о статусе авторизации
     */
    public function auth()
    {
        $mediator = new FunctionMediator();
        $mediator->setStatus(false);

        $api = new Api();

        $authConfig = Auth::getInstance();

        $accessToken = $api->getAccessToken();
        if ( ! $accessToken) {
            $mediator->setMessage('Ошибка при получении access token');

            return $mediator;
        }
        $authConfig->push(Auth::ACCESS_TOKEN, $accessToken);

        if ( ! $api->validateScopes(Api::SCOPES_FOR_AUTH, $accessToken)) {
            $mediator->setMessage('Пользователь предоставил недостаточно сведений');

            return $mediator;
        }

        $userinfo = $api->userinfoFull($accessToken);
        if (count($userinfo[ApiConfig::SCOPES_USERINFO]) === 0) {
            $mediator->setMessage('Ошибка при получении пользователя');

            return $mediator;
        }

        $mediator->setStatus(true);
        $mediator->setPayload($userinfo);

        return $mediator;
    }
}