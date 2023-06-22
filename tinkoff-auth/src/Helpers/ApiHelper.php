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
        if (!$userScopes || !$scopeForCompare) {
            return false;
        }

        if (count($scopeForCompare) == 1 && strpos($scopeForCompare[0], '[') !== false) {
            $scope = $scopeForCompare[0];
            $scope = preg_replace('/\[\{.+?\}\]/suix', '', $scope);
            foreach ($userScopes as &$userScope) {
                $userScope = preg_replace('/\[.+?\]/suix', '', $userScope);
            }

            return in_array($scope, $userScopes);
        }

        foreach ($scopeForCompare as $scope) {
            if (!in_array($scope, $userScopes)) {
                return false;
            }
        }

        return true;
    }
}