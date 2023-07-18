# Получить результат проверки паспорта в СМЭВ 3.0

1. Необходимо согласие пользователя на получение информации о паспортных данных. 
2. Метод возвращает информацию о статусе запроса на проверку паспорта в СМЭВ 3.0. 
3. В поле scopes у токена должен присутствовать scope вида ```opensme/individual/passport-check-smev```

AUTHORIZATIONS: httpAuth

Responses

=== "200"

    200 Запрос найден, статус получен

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` `(SMEVPassportCheckStatus)` (Идентификатор запроса)
    

    RESPONSE SCHEMA: application/json
    `requestId` (required) - `string <uuid>` (Идентификатор запроса проверки в СМЭВ 3.0 (для получения результата))


    Пример запроса

    ```POST https://business.tinkoff.ru/openapi/api/v1/individual/documents/passport-check-smev```

    Пример упешного (200) ответа:

    ```
    {
      "requestId": "30109424-c045-4831-9307-31121a0d2045"
    }
    ```

=== "400"

    400 Некорректный запрос

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` `<= 50 characters` (Идентификатор запроса)

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorCode` (required)       | string `<= 50 characters` | Код ошибки |
    | `errorId` (required)       | string `<= 50 characters` | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string `<= 400 characters` | Текст ошибки |
    | `errorDetails `  | object | Дополнительные данные об ошибке |

=== "401"

    401 Ошибка аутентификации

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` `<= 50 characters` (Идентификатор запроса)

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorCode` (required)       | string `<= 50 characters` | Код ошибки |
    | `errorId` (required)       | string `<= 50 characters` | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string `<= 400 characters` | Текст ошибки |

=== "403"

    403 Ошибка авторизации

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` `<= 50 characters` (Идентификатор запроса)

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorCode` (required)       | string `<= 50 characters` | Код ошибки |
    | `errorId` (required)       | string `<= 50 characters` | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string `<= 400 characters` | Текст ошибки |

=== "422"

    422 Ошибка при обработке данных

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` `<= 50 characters` (Идентификатор запроса)

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorCode` (required)       | string `<= 50 characters` | Код ошибки |
    | `errorId` (required)       | string `<= 50 characters` | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string `<= 400 characters` | Текст ошибки |

=== "429"

    429 Слишком много запросов

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` `<= 50 characters` (Идентификатор запроса)

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorCode` (required)       | string `<= 50 characters` | Код ошибки |
    | `errorId` (required)       | string `<= 50 characters` | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string `<= 400 characters` | Текст ошибки |

=== "500"

    500 Ошибка сервера

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` `<= 50 characters` (Идентификатор запроса)

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorCode` (required)       | string `<= 50 characters` | Код ошибки |
    | `errorId` (required)       | string `<= 50 characters` | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string `<= 400 characters` | Текст ошибки |
