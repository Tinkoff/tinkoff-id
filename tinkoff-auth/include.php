<?php

use TinkoffAuth\Config\Auth;

require_once __DIR__ . '/cms/spl.php';

define('TINKOFF_AUTH_FIELD_CLIENT_ID', 'tinkoff_auth_client_id');
define('TINKOFF_AUTH_FIELD_CLIENT_SECRET', 'tinkoff_auth_client_secret');
define('TINKOFF_AUTH_FIELD_BLOCKED_GROUPS', 'tinkoff_auth_blocked_groups');

define('TINKOFF_AUTH_FIELD_BUTTON_SIZE', 'tinkoff_auth_button_size');
define('TINKOFF_AUTH_FIELD_BUTTON_COLOR', 'tinkoff_auth_button_color');
define('TINKOFF_AUTH_FIELD_BUTTON_LANG', 'tinkoff_auth_button_lang');


$host = $_SERVER['HTTP_HOST'];
$uri  = '/bitrix/services/main/ajax.php?action=tinkoffid.authflow.sign';

$authConfig = Auth::getInstance();
$authConfig->push(Auth::CLIENT_ID, \COption::GetOptionString('tinkoffid', TINKOFF_AUTH_FIELD_CLIENT_ID));
$authConfig->push(Auth::CLIENT_SECRET, \COption::GetOptionString('tinkoffid', TINKOFF_AUTH_FIELD_CLIENT_SECRET));
$authConfig->push(Auth::REDIRECT_URI, 'https://' . $host . $uri);