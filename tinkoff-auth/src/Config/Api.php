<?php

namespace TinkoffAuth\Config;

class Api extends Config
{
    const USER_SCOPES = 'user_scopes';

    const SCOPES_USERINFO             = 'scopes_userinfo';
    const SCOPES_PASSPORT_SHORT       = 'scopes_passport_short';
    const SCOPES_PASSPORT             = 'scopes_passport';
    const SCOPES_DRIVER_LICENSES      = 'scopes_driver_licenses';
    const SCOPES_INN                  = 'scopes_inn';
    const SCOPES_SNILS                = 'scopes_snils';
    const SCOPES_ADDRESSES            = 'scopes_addresses';
    const SCOPES_IDENTIFICATION       = 'scopes_identification';
    const SCOPES_SELF_EMPLOYED_STATUS = 'scopes_self_employed_status';
    const SCOPES_DEBIT_CARDS          = 'scopes_debit_cards';
    const SCOPES_SUBSCRIPTION         = 'scopes_subscription';
    const SCOPES_COBRAND_STATUS       = 'scopes_cobrand_status';

    protected $availableIndexes = [
        self::USER_SCOPES,

        self::SCOPES_USERINFO,
        self::SCOPES_PASSPORT_SHORT,
        self::SCOPES_PASSPORT,
        self::SCOPES_DRIVER_LICENSES,
        self::SCOPES_INN,
        self::SCOPES_SNILS,
        self::SCOPES_ADDRESSES,
        self::SCOPES_IDENTIFICATION,
        self::SCOPES_SELF_EMPLOYED_STATUS,
        self::SCOPES_DEBIT_CARDS,
        self::SCOPES_SUBSCRIPTION,
        self::SCOPES_COBRAND_STATUS,
    ];

    /**
     * @var Api|null Текущий объект синглтона
     */
    protected static $instance = null;

    /**
     * @return Api
     */
    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }

        self::$instance = new self();

        return self::getInstance();
    }

    /**
     * @return array[]
     */
    public function getScopes()
    {
        return [
            self::SCOPES_USERINFO             => [
                'profile',
                'phone',
                'email',
            ],
            self::SCOPES_PASSPORT_SHORT       => [
                'opensme/individual/passport-short/get'
            ],
            self::SCOPES_PASSPORT             => [
                'opensme/individual/passport/get'
            ],
            self::SCOPES_DRIVER_LICENSES      => [
                'opensme/individual/driver-licenses/get'
            ],
            self::SCOPES_INN                  => [
                'opensme/individual/inn/get'
            ],
            self::SCOPES_SNILS                => [
                'opensme/individual/snils/get'
            ],
            self::SCOPES_ADDRESSES            => [
                'opensme/individual/addresses/get'
            ],
            self::SCOPES_IDENTIFICATION       => [
                'opensme/individual/identification/status/get'
            ],
            self::SCOPES_SELF_EMPLOYED_STATUS => [
                'opensme/individual/self-employed/status/get'
            ],
            self::SCOPES_DEBIT_CARDS          => [
                'opensme/individual/accounts/debit/get'
            ],
            self::SCOPES_SUBSCRIPTION         => [
                'opensme/individual/subscription/get'
            ],
            self::SCOPES_COBRAND_STATUS       => [
                'opensme/individual/cobrand/status/get'
            ],
        ];
    }

    public function getScopesURLs()
    {
        return [
            self::SCOPES_USERINFO             => 'https://id.tinkoff.ru/userinfo/userinfo',
            self::SCOPES_PASSPORT_SHORT       => 'https://business.tinkoff.ru/openapi/api/v1/individual/documents/passport-short',
            self::SCOPES_PASSPORT             => 'https://business.tinkoff.ru/openapi/api/v1/individual/documents/passport',
            self::SCOPES_DRIVER_LICENSES      => 'https://business.tinkoff.ru/openapi/api/v1/individual/documents/driver-licenses',
            self::SCOPES_INN                  => 'https://business.tinkoff.ru/openapi/api/v1/individual/documents/inn',
            self::SCOPES_SNILS                => 'https://business.tinkoff.ru/openapi/api/v1/individual/documents/snils',
            self::SCOPES_ADDRESSES            => 'https://business.tinkoff.ru/openapi/api/v1/individual/addresses',
            self::SCOPES_IDENTIFICATION       => 'https://business.tinkoff.ru/openapi/api/v1/individual/identification/status',
            self::SCOPES_SELF_EMPLOYED_STATUS => 'https://business.tinkoff.ru/openapi/api/v1/individual/self-employed/status',
            self::SCOPES_DEBIT_CARDS          => 'https://business.tinkoff.ru/openapi/api/v1/individual/accounts/debit',
            self::SCOPES_SUBSCRIPTION         => 'https://business.tinkoff.ru/openapi/api/v1/individual/subscription',
            self::SCOPES_COBRAND_STATUS       => 'https://business.tinkoff.ru/openapi/api/v1/individual/cobrand/%s',
        ];
    }
}