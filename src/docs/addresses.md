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