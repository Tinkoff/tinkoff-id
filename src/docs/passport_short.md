# Получить паспортные данные с проверкой в ФНС

Необходимо согласие пользователя на получение информации о паспортных данных. В поле scope у токена должен присутствовать доступ вида ```opensme/individual/passport-short/get```

AUTHORIZATIONS: httpAuth

Responses

=== "200 Паспорт гражданина РФ"

    200 Паспорт гражданина

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса
    


    RESPONSE SCHEMA: application/json

    | Parameters      | Type     | Description                          |
    | ----------- | --------------- | --------------------- |
    | `birthDate`       | string <date> | Дата рождения |
    | `citizenship`    | string | Гражданство|
    | `issueDate`    | string <date> | Дата выдачи|
    | `serialNumber`    | string | Серия и номер|
    | `unitCode`    | string | Код подразделения|
    | `unitName`    | string | Название подразделения|


    Пример запроса

    ```GET https://business.tinkoff.ru/openapi/api/v1/individual/documents/passport-short```

    Пример упешного (200) ответа:

    ```
    {
      "birthDate": "2020-09-01",
      "citizenship": "РФ",
      "issueDate": "2020-09-01",
      "serialNumber": "1234567890",
      "unitCode": "123-456",
      "unitName": "УМВД РОССИИ ПО Г. МОСКВЕ",
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

    Примеры ответа ошибкии 400:

    Ошибка при неправильно заполненном ИНН
    ```
    {
      "errorId": "retw6789",
      "errorMessage": "Некорректно заполнен ИНН",
      "errorCode": "VALIDATION_ERROR"
    }
    ```

    Ошибка при неправильно переданном значении поля revenueTypeCode

    ```
    {
      "errorId": "cde4zxc5",
      "errorMessage": "Ваш запрос невалиден",
      "errorCode": "INVALID_DATA",
      "errorDetails": {
        "revenueTypeCode": "expected revenueTypeCode to be within List(1, 2, 3), but was '0'"
      }
    }
    ```



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

    Примеры ответа ошибкии 422:

    ```
    {
      "errorId": "bcde3412",
      "errorMessage": "На балансе недостаточно средств",
      "errorCode": "INSUFFICIENT_FUNDS"
    }
    ```

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


