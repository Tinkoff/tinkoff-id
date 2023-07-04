# Получить паспортные данные

Необходимо согласие пользователя на получение информации о паспортных данных. В поле scope у токена должен присутствовать доступ вида ```opensme/individual/passport/get```

Тип документа может принимать одно из следующих значений:

- PASSPORT - Паспорт РФ
- FOREIGN_PASSPORT - Иностранный паспорт
- FOREIGN_INTERNATIONAL_PASSPORT - Загран. паспорт иностранного гражданина
- RF_INTERNATIONAL_PASSPORT - Загран. паспорт гражданина РФ
- BIRTH_CERTIFICATE - Свидетельство о рождении
- RF_RESIDENCE_PERMIT - Вид на жительство РФ

AUTHORIZATIONS: httpAuth

Responses

=== "200 Паспорт гражданина"

    200 Паспорт гражданина

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса
    


    RESPONSE SCHEMA: application/json

    | Parameters      | Type     | Description                          |
    | ----------- | --------------- | --------------------- |
    | `birthDate`       | string <date> | Дата рождения |
    | `birthPlace`       | string | Место рождения  |
    | `citizenship`    | string | Гражданство|
    | `issueDate`    | string <date> | Дата выдачи|
    | `maritalStatus`    | string | Семейное положение|
    | `marriageDate`    | string <date> | Дата регистрации брака|
    | `numberOfChildren`    | integer | Количество детей|
    | `resident`    | boolean | Является гражданином РФ|
    | `serialNumber`    | string | Серия и номер|
    | `unitCode`    | string | Код подразделения|
    | `unitName`    | string | Название подразделения|
    | `validTo`    | string <date> | Время действия паспорта|


    Пример запроса

    ```GET https://business.tinkoff.ru/openapi/api/v1/individual/documents/passport```

    Пример упешного (200) ответа:

    ```
    {
      "birthDate": "2020-09-01",
      "birthPlace": "Г. МОСКВА",
      "citizenship": "РФ",
      "issueDate": "2020-09-01",
      "maritalStatus": "Женат/замужем",
      "marriageDate": "2020-09-01",
      "numberOfChildren": 0,
      "resident": true,
      "serialNumber": "1234567890",
      "unitCode": "123-456",
      "unitName": "УМВД РОССИИ ПО Г. МОСКВЕ",
      "validTo": "2020-09-01"
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


