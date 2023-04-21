<?php

namespace TinkoffAuth\Config;

class State extends Config
{
    const PROVIDER = 'provider';

    protected $availableIndexes = [
        self::PROVIDER
    ];

    /**
     * @var State|null Текущий объект синглтона
     */
    protected static $instance = null;

    /**
     * @return State
     */
    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }

        self::$instance = new self();

        return self::getInstance();
    }
}