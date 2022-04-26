#Получить водительские удостоверения

Необходимо согласие пользователя на получение информации о водительских удостоверениях. В поле scope у токена должен присутствовать доступ вида ```opensme/individual/driver-licenses/get```

AUTHORIZATIONS: httpAuth

Responses

=== "200 Водительские удостоверения"

    200 Водительские удостоверения

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса
    


    RESPONSE SCHEMA: application/json

    | Parameters      | Type     | Description                          |
    | ----------- | --------------- | --------------------- |
    | `licenses`       | array of objects <DriverLicenseResponse> | Водительские удостоверения физического лица |
    | `docNumber`       | string | Номер документа водительского удостоверения  |
    | `issueDate`    | string <date> | Дата выдачи водительского удостоверения |
 

=== "400"

    400 Некорректный запрос

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |
    | `errorDetails ` (required)       | object | Дополнительные данные об ошибке |

=== "401"

    401 Ошибка аутентификации

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |

=== "403"

    403 Ошибка авторизации

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |


=== "422"

    422 Ошибка при обработке данных

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters    | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |
    | `errorDetails ` (required)       | object | Дополнительные данные об ошибке |

=== "429"

    429 Слишком много запросов

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters     | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |

=== "500"

    500 Ошибка сервера

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |