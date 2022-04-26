#Получить паспортные данные

Необходимо согласие пользователя на получение информации о паспортных данных. В поле scope у токена должен присутствовать доступ вида ```opensme/individual/passport/get```

AUTHORIZATIONS: httpAuth

Responses

=== "200 Паспорт гражданина РФ"

    200 Паспорт гражданина РФ

    RESPONSE HEADERS
    Идентификатор запроса

    | X-Request-Id (required)    | string   | Идентификатор запроса     |
     


    RESPONSE SCHEMA: application/json

    | Method      | Type     | Description                          |
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

=== "400"

    400 Некорректный запрос

    RESPONSE HEADERS

    | X-Request-Id (required)    | string   | Идентификатор запроса     |

    RESPONSE SCHEMA: application/json

    | Method      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |
    | `errorDetails ` (required)       | object | Дополнительные данные об ошибке |

=== "401"

    401 Ошибка аутентификации

    RESPONSE HEADERS

    | X-Request-Id (required)    | string   | Идентификатор запроса |

    RESPONSE SCHEMA: application/json

    | Method      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |

=== "403"

    403 Ошибка авторизации

    RESPONSE HEADERS

    | X-Request-Id (required)    | string   | Идентификатор запроса     |

    RESPONSE SCHEMA: application/json

    | Method      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |


=== "422"

    422 Ошибка при обработке данных

    RESPONSE HEADERS

    | X-Request-Id (required)    | string   | Идентификатор запроса     |

    RESPONSE SCHEMA: application/json

    | Method      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |
    | `errorDetails ` (required)       | object | Дополнительные данные об ошибке |

=== "429"

    429 Слишком много запросов

    RESPONSE HEADERS

    | X-Request-Id (required)    | string   | Идентификатор запроса     |

    RESPONSE SCHEMA: application/json

    | Method      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |

=== "500"

    500 Ошибка сервера

    RESPONSE HEADERS

    | X-Request-Id (required)    | string   | Идентификатор запроса     |

    RESPONSE SCHEMA: application/json

    | Method      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |