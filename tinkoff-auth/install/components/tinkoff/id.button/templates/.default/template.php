<?php

use TinkoffAuth\Config\Auth;
use TinkoffAuth\Facades\Tinkoff;
use TinkoffAuth\View\AuthButton\AuthButton;

$authConfig = Auth::getInstance();

$size  = \COption::GetOptionString('tinkoffid', TINKOFF_AUTH_FIELD_BUTTON_SIZE, null);
$color = \COption::GetOptionString('tinkoffid', TINKOFF_AUTH_FIELD_BUTTON_COLOR, null);
$lang  = \COption::GetOptionString('tinkoffid', TINKOFF_AUTH_FIELD_BUTTON_LANG, null);


$tinkoff = new Tinkoff();
$link    = $tinkoff->getAuthURL($authConfig->get(Auth::REDIRECT_URI));

echo (new AuthButton($link, $size, $color, $lang))->render();
