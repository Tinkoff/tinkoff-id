<?php

namespace TinkoffAuth\Helpers;

use TinkoffAuth\Config\Api;
use TinkoffAuth\Config\Auth;
use TinkoffAuth\Services\Http\Response;

class ApiFormatter
{
    /**
     * Форматирование параметров Introspect
     *
     * @param Response $response
     *
     * @return array
     */
    public static function formatIntrospectParams(Response $response)
    {
        $result = $response->json();

        return array_merge([
            'active'    => false,
            'scope'     => [],
            'client_id' => null,
            'iss'       => null,
        ], $result);
    }

    /**
     * Форматирование параметров Access Token
     *
     * @param Response $response
     *
     * @return array
     */
    public static function formatTokenParams(Response $response)
    {
        $result = $response->json();

        $accessToken = isset($result['access_token']) && $result['access_token'] ? $result['access_token'] : null;
        if ($accessToken) {
            $authConfig = Auth::getInstance();
            $authConfig->push(Auth::ACCESS_TOKEN, $accessToken);
        }

        $tokenType    = isset($result['token_type']) && $result['token_type'] ? $result['token_type'] : 'Bearer';
        $expiresIn    = isset($result['expires_in']) && $result['expires_in'] ? $result['expires_in'] : 0;
        $refreshToken = isset($result['refresh_token']) && $result['refresh_token'] ? $result['refresh_token'] : null;

        return [
            'access_token'  => $accessToken,
            'token_type'    => $tokenType,
            'expires_in'    => $expiresIn,
            'refresh_token' => $refreshToken,
        ];
    }

    /**
     * Форматирование параметров для получений полной информации по пользователю
     *
     * @param array $data
     *
     * @return array
     */
    public static function formatUserinfoFull(array $data = [])
    {
        return [
            Api::SCOPES_USERINFO               => self::getScopeDataSafely($data, Api::SCOPES_USERINFO),
            Api::SCOPES_PASSPORT_SHORT         => self::getScopeDataSafely($data, Api::SCOPES_PASSPORT_SHORT),
            Api::SCOPES_PASSPORT               => self::getScopeDataSafely($data, Api::SCOPES_PASSPORT),
            Api::SCOPES_DRIVER_LICENSES        => self::getScopeDataSafely($data, Api::SCOPES_DRIVER_LICENSES),
            Api::SCOPES_INN                    => self::getScopeDataSafely($data, Api::SCOPES_INN),
            Api::SCOPES_SNILS                  => self::getScopeDataSafely($data, Api::SCOPES_SNILS),
            Api::SCOPES_ADDRESSES              => self::getScopeDataSafely($data, Api::SCOPES_ADDRESSES),
            Api::SCOPES_IDENTIFICATION         => self::getScopeDataSafely($data, Api::SCOPES_IDENTIFICATION),
            Api::SCOPES_SELF_EMPLOYED_STATUS   => self::getScopeDataSafely($data, Api::SCOPES_SELF_EMPLOYED_STATUS),
            Api::SCOPES_DEBIT_CARDS            => self::getScopeDataSafely($data, Api::SCOPES_DEBIT_CARDS),
            Api::SCOPES_SUBSCRIPTION           => self::getScopeDataSafely($data, Api::SCOPES_SUBSCRIPTION),
            Api::SCOPES_COBRAND_STATUS         => self::getScopeDataSafely($data, Api::SCOPES_COBRAND_STATUS),
            Api::SCOPES_PUBLIC_OFFICIAL_PERSON => self::getScopeDataSafely($data, Api::SCOPES_PUBLIC_OFFICIAL_PERSON),
            Api::SCOPES_FOREIGN_AGENT          => self::getScopeDataSafely($data, Api::SCOPES_FOREIGN_AGENT),
            Api::SCOPES_BLACKLIST_STATUS       => self::getScopeDataSafely($data, Api::SCOPES_BLACKLIST_STATUS),
            Api::SCOPES_BANK_ACCOUNTS          => self::getScopeDataSafely($data, Api::SCOPES_BANK_ACCOUNTS),
            Api::SCOPES_COMPANY_INFO           => self::getScopeDataSafely($data, Api::SCOPES_COMPANY_INFO),
            Api::SCOPES_BANK_STATEMENTS        => self::getScopeDataSafely($data, Api::SCOPES_BANK_STATEMENTS),
        ];
    }

    private static function getScopeDataSafely($data, $index)
    {
        return isset($data[$index]) && $data[$index] ? $data[$index] : [];
    }
}