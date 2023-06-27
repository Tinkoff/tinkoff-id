<?php

namespace TinkoffAuth\Config;

class Auth extends Config
{
    const CLIENT_ID = 'client_id';
    const CLIENT_SECRET = 'client_secret';
    const REDIRECT_URI = 'redirect_uri';
    const ACCESS_TOKEN = 'access_token';

    protected $availableIndexes = [
        self::CLIENT_ID,
        self::CLIENT_SECRET,
        self::REDIRECT_URI,
        self::ACCESS_TOKEN,
    ];

    /**
     * @var Auth|null Текущий объект синглтона
     */
    protected static $instance = null;

    /**
     * @return Auth
     */
    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }

        self::$instance = new self();

        return self::getInstance();
    }

    public function getUsername()
    {
        return $this->get(self::CLIENT_ID);
    }

    public function getPassword()
    {
        return $this->get(self::CLIENT_SECRET);
    }
}