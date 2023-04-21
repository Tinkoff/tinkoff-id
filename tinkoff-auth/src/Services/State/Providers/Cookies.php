<?php

namespace TinkoffAuth\Services\State\Providers;

class Cookies extends Provider
{
    const COOKIE_NAME = 'tinkoff_auth_state';

    /**
     * Создание стейта и занесение его в куки
     *
     * @return bool
     */
    public function createState()
    {
        $cookieState = $this->getCookieState();
        if ($cookieState) {
            self::$state = $cookieState;

            return true;
        }

        self::$state = $this->generateRandomString();
        setcookie(self::COOKIE_NAME, self::$state, null, '/', "", true);

        return true;
    }

    /**
     * Проверка стейта по данным в куках и переданному стейту
     *
     * @param string|null $string
     *
     * @return bool
     */
    public function validateState($string = null)
    {
        $cookieState = $this->getCookieState();
        if (is_null($cookieState)) {
            return false;
        }

        return $cookieState === $string;
    }

    private function getCookieState()
    {
        return isset($_COOKIE[self::COOKIE_NAME]) && $_COOKIE[self::COOKIE_NAME] ? $_COOKIE[self::COOKIE_NAME] : null;
    }
}