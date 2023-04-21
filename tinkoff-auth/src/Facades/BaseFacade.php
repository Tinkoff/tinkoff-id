<?php

namespace TinkoffAuth\Facades;

use TinkoffAuth\Config\Auth;

abstract class BaseFacade
{
    public function __construct($clientID = null, $clientSecret = null)
    {
        $config = Auth::getInstance();
        if ($clientID) {
            $config->push(Auth::CLIENT_ID, $clientID);
        }
        if ($clientSecret) {
            $config->push(Auth::CLIENT_SECRET, $clientSecret);
        }
    }
}