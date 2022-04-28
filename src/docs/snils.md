#Получить СНИЛС

Необходимо согласие пользователя на получение информации о СНИЛС. В поле scope у токена должен присутствовать доступ вида ```opensme/individual/snils/get```

AUTHORIZATIONS: httpAuth

Responses

=== "200 СНИЛС"

    200 СНИЛС

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса
    


    RESPONSE SCHEMA: application/json

    | Parameters      | Type     | Description                          |
    | ----------- | --------------- | --------------------- |
    | `snils`       | string ^(\d{11})$ | СНИЛС |

 

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

Пример запроса

```GET https://business.tinkoff.ru/openapi/api/v1/individual/documents/snils```

Пример ответа

```
{
  "snils": "12345678901"
}
```