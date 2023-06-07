#Получить информацию о статусе самозанятого
Необходимо согласие пользователя на получение информации о  его статусе как самозанятого. В поле scope у токена должен присутствовать доступ вида ```opensme/individual/self-employed/status/get```

AUTHORIZATIONS: httpAuth

Responses

=== "200 Статус самозанятого"

    200 Получить информацию о статусе самозанятого

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса
    


    RESPONSE SCHEMA: application/json

    | Parameters      | Type     | Description                          |
    | ----------- | --------------- | --------------------- |
    | `isSelfEmployed` (required)       | boolean | Является ли пользователь самозанятым |

    Пример запроса

    ```GET https://business.tinkoff.ru/openapi/api/v1/individual/self-employed/status```

    Пример ответа

    ```
    {
      "isSelfEmployed": true
    }
    ```
 

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

    Примеры ответа ошибкии 401:

    ```
    {
      "errorId": "asdq3412",
      "errorMessage": "Не хватает учетных данных",
      "errorCode": "UNAUTHORIZED"
    }
    ```

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

    Примеры ответа ошибкии 403:

    ```
    {
      "errorId": "rtbe4567",
      "errorMessage": "Неправильный Tls сертификат",
      "errorCode": "FORBIDDEN"
    }
    ```


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

    Примеры ответа ошибкии 429:

    ```
    {
    "errorMessage": "Слишком много запросов. Попробуйте позже",
    "errorCode": "TOO_MANY_REQUESTS",
    "errorId": "acdf000"
    }
    ```

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

    Примеры ответа ошибкии 500:

    ```
    {
      "errorId": "asdq3412",
      "errorMessage": "Непредвиденная ошибка. Пожалуйста, попробуйте позже",
      "errorCode": "INTERNAL_ERROR"
    }
    ```
