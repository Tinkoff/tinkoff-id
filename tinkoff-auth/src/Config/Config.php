<?php

namespace TinkoffAuth\Config;

use TinkoffAuth\Exceptions\UnknownConfig;

abstract class Config
{
    /**
     * @var array
     */
    protected $store = [];
    /**
     * @var array
     */
    protected $availableIndexes = [];

    protected function __construct()
    {
    }

    /**
     * @param $index
     * @param null $default
     * @return mixed|null
     */
    public function get($index, $default = null)
    {
        return isset($this->store[$index]) && $this->store[$index] ? $this->store[$index] : $default;
    }

    /**
     * @param $index
     * @param $value
     *
     * @return bool
     */
    public function push($index, $value)
    {
        if (!in_array($index, $this->availableIndexes)) {
            return false;
        }
        $this->store[$index] = $value;

        return true;
    }

    public function remove($index)
    {
        unset($this->store[$index]);
    }
}