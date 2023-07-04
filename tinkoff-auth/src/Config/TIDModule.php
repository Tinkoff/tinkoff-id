<?php

namespace TinkoffAuth\Config;

class TIDModule extends Config
{
    const ENABLE_LOG = 'ENABLE_LOG';

    protected $availableIndexes = [
        self::ENABLE_LOG,
    ];

    /**
     * @var TIDModule|null Текущий объект синглтона
     */
    protected static $instance = null;

    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }

        self::$instance = new self();

        return self::getInstance();
    }

    public function isLogEnable()
    {
        return !!$this->get(self::ENABLE_LOG, false);
    }

}