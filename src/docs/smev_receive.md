# Получить результат проверки паспорта в СМЭВ 3.0

1. Необходимо согласие пользователя на получение информации о паспортных данных. 
2. Метод возвращает информацию о статусе запроса на проверку паспорта в СМЭВ 3.0. 
3. В поле scopes у токена должен присутствовать scope вида ```opensme/individual/passport-check-smev```

AUTHORIZATIONS: httpAuth

Responses

=== "200"

    200 Запрос найден, статус получен
    
    RESPONSE HEADERS
    
    `X-Request-Id` (required) - `string` `<= 50 characters` (Идентификатор запроса)
    

    RESPONSE SCHEMA: application/json
    
    `requestId` (required) - `string (SMEVPassportCheckStatus)`
    
    Enum: `"IN_PROGRESS"` `"VALID"` `"INVALID"`
    
    Статус/результат проверки паспортных данных в СМЭВ 3.0:
    
    `IN_PROGRESS` - Процесс проверки еще не закончен. Повторите запрос через некоторое время
    
    `VALID` - Паспорт действителен
    
    `INVALID` - Паспорт недействителен или не существует
    
    Пример запроса

    ```GET https://business.tinkoff.ru/openapi/api/v1/individual/documents/passport-check-smev```

    Пример упешного (200) ответа:

    ```
    {
      "result": "IN_PROGRESS"
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
