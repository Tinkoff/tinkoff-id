## Bitrix

Название папки модуля: `tinkoffid` 

Redirect URI в заявке: https://ваш_домен/bitrix/services/main/ajax.php?action=tinkoffid.authflow.sign 

### Настройка плагина

Вся настройка плагина производится во вкладке "Настройки" в пункте "Модули"

### Вывод кнопки

Для вывода кнопки, необходимо в нужном месте подключить компонент

```php
<?php $APPLICATION->IncludeComponent("tinkoff:id.button","",);?>
```

## WordPress

Redirect URI в заявке: https://ваш_домен/wp-json/tinkoff_auth/v1/callback

### Настройка плагина

Вся настройка плагина производится во вкладке "Настройки" в пункте "Тинькофф"

### Вывод кнопки

Для вывода кнопки, можно использовать шорткод `[tinkoff-button]`, либо настроить вывод в стандартные места темы через
настройки

## Standalone

### Предварительная настройка

Для начала работы с Tinkoff API необходимо заполнить заявку на
подключение [на этой странице](https://www.tinkoff.ru/business/open-api/).
После рассмотрения заявки сотрудниками банка будут высланы client_id и client_secret на электронную почту,
которая была указана в партнерской анкете.

Одним из пунктов партнерской анкеты является указание параметра redirect_uri.
Необходимо создать эндпоинт, доступный по redirect_uri, который заканчивает процесс авторизации
путем обмена кода на Access и Refresh токены. В качестве примера, эндпоинт-ссылкой
будет https://myintegration.ru/auth/complete, где https://myintegration.ru - страница продукта.

```php
use TinkoffAuth\Config\Auth;

use \TinkoffAuth\Config\State;
use \TinkoffAuth\Services\State\Providers\Session;
use \TinkoffAuth\Services\State\Providers\Cookies;


require_once __DIR__.'/../vendor/autoload.php';

// Настройка данных для авторизации 
$authConfig = Auth::getInstance();
$authConfig->push(Auth::CLIENT_ID, 'client_id');
$authConfig->push(Auth::CLIENT_SECRET, 'client_secret');
$authConfig->push(Auth::REDIRECT_URI, 'https://myintegration.ru/auth/complete')

// Настройка места хранения стейта
$stateConfig = State::getInstance();
$stateConfig->push(State::PROVIDER, Session::class)
$stateConfig->push(State::PROVIDER, Cookies::class)
```

### Получение ссылки для авторизации

Для получения ссылки на авторизацию, необходимо указать redirect_uri в
методе `getAuthURL($redirect_uri = null, $scope_parameters = [])`.
При необходимости, можно указать массив `scope_parameters`. Подробнее можно
почитать [тут](https://business.tinkoff.ru/openapi/docs#section/Partnerskij-scenarij/Process-avtorizacii)

```php
use TinkoffAuth\Facades\Tinkoff;

$tinkoff = new Tinkoff();

$linkWithoutScope = $tinkoff->getAuthURL('https://myintegration.ru/auth/complete');

$linkWithScope = $tinkoff->getAuthURL('https://myintegration.ru/auth/complete', [
    "inn" => "9999980892", 
    "kpp" => "999991001" 
]);
```

### Отображение кнопки

Чтобы отобразить кнопку, можно вызвать класс `AuthButton` указав в нем ссылку на страницу авторизации

```php
//  Опционально можно указать размер кнопки
$buttonSize = \TinkoffAuth\View\AuthButton\AuthButton::BUTTON_SIZE_SMALL;
$buttonSize = \TinkoffAuth\View\AuthButton\AuthButton::BUTTON_SIZE_DEFAULT;
$buttonSize = \TinkoffAuth\View\AuthButton\AuthButton::BUTTON_SIZE_LARGE;

$button = new \TinkoffAuth\View\AuthButton\AuthButton($link, $buttonSize);
echo $button;
```

### Обработка данных после авторизации

#### Упрощенный режим

Для авторизации необходимо вызвать функцию `auth()` фасада `TinkoffAuth\Facades\Tinkoff::class`.
В ответ придет класс `FunctionMediator`, который содержит статус авторизации и данные об обшибке, либо данные о
пользователе

```php
use \TinkoffAuth\Facades\Tinkoff;
use \TinkoffAuth\Config\Api;

$tinkoff = new Tinkoff();

$mediator = $tinkoff->auth();
if (!$mediator->getStatus()) {
    $errorMessage = $mediator->getMessage();
    // Обработать ошибку
}

// Массив всех данных с ключами из \TinkoffAuth\Config\Api
$credentials = $mediator->getPayload();
// Основные данные пользователя
$userinfo = $credentials[Api::SCOPES_USERINFO]

// Обработать данные пользователя
```

#### Расширенный режим

На указанный redirect_uri придет запрос вида. Чтобы его обработать, можно воспользоваться методами ниже

```
https://myintegration.ru/auth/complete?state=ABCxyz&code=c.1aGiAXX3Ni&session_state=hXXXXXXY3kgs3nx0H3RTj3JzCSrdaqaDhU6lS8XXXXX.i4kl6dsEB1SQogzq0Nj0
```

```php
use \TinkoffAuth\Config\State;
use \TinkoffAuth\Services\State\Providers\Session;
use \TinkoffAuth\Services\State\Providers\Cookies;

use \TinkoffAuth\Config\Api as ApiConfig;

// Создаем объект для работы с API
$api = new Api();
// Указываем необходимость проверки State
$validateState = true;

// Данные, пришедшие на текущий URL + проверка State
$authParams = $api->getAuthParams($validateState);

// Получение Access Token по возможности + проверка State
$accessToken = $api->getAccessToken($validateState);

// Сохранение Access Token
$authConfig->push(Auth::ACCESS_TOKEN, $accessToken);

// Проверка Scopes 
if (!$api->validateScopes($accessToken)) {
    // Если доступов недостаточно
}

// Можно получить краткую информацию о пользователе
$userinfoShort = $api->userinfo($accessToken);
if (count($userinfoShort) === 0) {
    // Если основных пользовательских данных не найдено
}

// Либо полную, исходя из доступынх scopes
$userinfo = $api->userinfoFull($accessToken);
if (count($userinfo[ApiConfig::SCOPES_USERINFO]) === 0) {
    // Если основных пользовательских данных не найдено
}

// Обработать пользовательские данные
```
