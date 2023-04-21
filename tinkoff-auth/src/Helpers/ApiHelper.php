<?php

namespace TinkoffAuth\Helpers;

use TinkoffAuth\Exceptions\UnknownConfig;
use TinkoffAuth\Facades\Api;

class ApiHelper
{
    /**
     * Проверка scopes
     *
     * @param array $userScopes
     * @param array $scopeForCompare
     *
     * @return bool
     */
    public static function validateScopes(array $userScopes = [], array $scopeForCompare = [])
    {
        if ( ! $userScopes || ! $scopeForCompare) {
            return false;
        }

        foreach ($scopeForCompare as $scope) {
            if ( ! in_array($scope, $userScopes)) {
                return false;
            }
        }

        return true;
    }
}