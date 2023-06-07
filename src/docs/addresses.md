#Получить адреса

Необходимо согласие пользователя на получение информации об адресах. В поле scope у токена должен присутствовать доступ вида ```opensme/individual/addresses/get```

AUTHORIZATIONS: httpAuth

Responses

=== "200 Адреса"

    200 Получить адреса

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса
    


    RESPONSE SCHEMA: application/json

    | Parameters      | Type     | Description                          |
    | ----------- | --------------- | --------------------- |
    | `addresses `       | Array of objects (AddressResponse) | Адреса физического лица |
    | `addressType` (required)      | string (AddressType) | Enum: "RESIDENCE_ADDRESS" "REGISTRATION_ADDRESS" "WORK_ADDRESS"
    Тип адреса. Может принимать одно из трех значений:
    * REGISTRATION_ADDRESS - адрес регистрации
    * WORK_ADDRESS - рабочий адрес
    * RESIDENCE_ADDRESS - домашний адрес |
    | `apartment `       | string | Квартира |
    | `building`       | string | Строение |
    | `city`| string | Город |
    | `claddrCode`| string | Код адреса в КЛАДР |
    | `country`| string | Страна |
    | `district`| string | Район |
    | `fiasCode`| string | Код адреса в ФИАС |
    | `house`| string | Номер дома |
    | `housing`| string | Корпус |
    | `latitude`| number <double> | Широта |
    | `longitude`| number <double> | Долгота |
    | `primary` (required)| boolean | Является основным адресом |
    | `region` | string | Регион |
    | `settlement` | string | Населенный пункт |
    | `street` | string | Улица |
    | `zipCode` | string | Индекс |


    Пример запроса

    ```GET https://business.tinkoff.ru/openapi/api/v1/individual/addresses```

    Пример ответа

    ```
    {
      "addresses": [
        {
          "addressType": "REGISTRATION_ADDRESS",
          "apartment": "100",
          "city": "Г ЯРОСЛАВЛЬ",
          "claddrCode": "1200000600010530123",
          "country": "РОССИЯ",
          "fiasCode": "567845f8-72vb-45f3-ad16-bd4d12e06162",
          "house": "120",
          "latitude": 57.1234,
          "longitude": 39.5678,
          "primary": false,
          "region": "ЯРОСЛАВСКАЯ ОБЛ",
          "street": "УЛ ПРАВДЫ",
          "zipCode": "150001"
        }
      ]
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

