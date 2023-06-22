<?php

namespace TinkoffAuth\Services\State;

use TinkoffAuth\Config\State as StateConfig;
use TinkoffAuth\Services\State\Providers\Cookies;
use TinkoffAuth\Services\State\Providers\Provider;

class State
{
    /**
     * @var Provider|null
     */
    private $provider;

    /**
     * @param string|null $provider
     */
    public function __construct($provider = null)
    {
        $stateConfig = StateConfig::getInstance();

        if (!is_null($provider) && is_subclass_of($provider, Provider::class)) {
            $this->provider = new $provider();
        } else {
            $provider       = $stateConfig->get(StateConfig::PROVIDER)
                ? $stateConfig->get(StateConfig::PROVIDER)
                : Cookies::class;
            $this->provider = new $provider;
        }
    }

    /**
     * @return string
     */
    public function getState()
    {
        $this->provider->createState();

        return $this->provider->getStateValue();
    }

    /**
     * @return void
     */
    public function createState()
    {
        $this->provider->createState();
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    public function validate($string)
    {
        return $this->provider->validateState($string);
    }
}