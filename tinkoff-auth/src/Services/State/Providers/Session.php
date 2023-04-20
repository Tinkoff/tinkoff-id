<?php

namespace TinkoffAuth\Services\State\Providers;

class Session extends Provider
{
    const STATE_NAME = 'tinkoff_auth_state';

    /**
     * Создание стейта внутри сессии
     *
     * @return bool
     */
    public function createState()
    {
        session_start();

        $this->state = $this->generateRandomString();

        $_SESSION[self::STATE_NAME] = $this->state;

        return true;
    }

    /**
     * Проверка стейта внутри сессии с переданным стейтом
     *
     * @param string|null $string
     *
     * @return bool
     */
    public function validateState($string = null)
    {
        $sessionState = isset($_SESSION[self::STATE_NAME]) && $_SESSION[self::STATE_NAME] ? $_SESSION[self::STATE_NAME] : null;
        if (is_null($sessionState)) {
            return false;
        }

        return $sessionState === $string;
    }

}