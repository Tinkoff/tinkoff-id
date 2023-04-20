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
     *
     * @return mixed|null
     */
    public function get($index)
    {
        return isset($this->store[$index]) && $this->store[$index] ? $this->store[$index] : null;
    }

    /**
     * @param $index
     * @param $value
     *
     * @return bool
     */
    public function push($index, $value)
    {
        if ( ! in_array($index, $this->availableIndexes)) {
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