<?php

namespace TinkoffAuth\Exceptions;

use Exception;

class UnknownConfig extends Exception
{
    protected $message = 'Can\'t initialize singleton config class';
}