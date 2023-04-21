<?php

namespace TinkoffAuth\Services\State\Providers;

abstract class Provider
{
    /**
     * @var string Текущий стейт
     */
    protected static $state;

    /**
     * Создание стейта и сохранение его
     *
     * @return bool
     */
    public function createState()
    {
        $this->state = '';

        return false;
    }

    /**
     * Получение стейта
     *
     * @return string
     */
    public function getStateValue()
    {
        return self::$state;
    }

    /**
     * Проверка стейта
     *
     * @param string|null $string
     *
     * @return bool
     */
    public function validateState($string = null)
    {
        return false;
    }

    protected function generateRandomString($length = 20)
    {
        return substr(
            str_shuffle(
                str_repeat(
                    $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                    ceil($length / strlen($x))
                )
            ),
            1,
            $length
        );
    }
}