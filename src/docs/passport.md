#Получить паспортные данные

Необходимо согласие пользователя на получение информации о паспортных данных. В поле scope у токена должен присутствовать доступ вида ```opensme/individual/passport/get```

AUTHORIZATIONS: httpAuth

Responses

=== "200 Паспорт гражданина РФ"

    200 Паспорт гражданина РФ

    RESPONSE HEADERS
    Идентификатор запроса

    | X-Request-Id     | string                         |
    | ----------- | ------------------------------------ |
    | required      | Идентификатор запроса  |


    RESPONSE SCHEMA: application/json

    | Method      | Description                          |
    | ----------- | ------------------------------------ |
    | `birthDate`       | string <date>: Дата рождения |
    | `birthPlace`       | string: Место рождения  |
    | `citizenship`    | string: Гражданство|
    | `issueDate`    | string <date>: Дата выдачи|
    | `maritalStatus`    | string: Семейное положение|
    | `marriageDate`    | string <date>: Дата регистрации брака|
    | `numberOfChildren`    | integer: Количество детей|
    | `resident`    | boolean: Является гражданином РФ|
    | `serialNumber`    | string: Серия и номер|
    | `unitCode`    | string: Код подразделения|
    | `unitName`    | string: Название подразделения|
    | `validTo`    | string <date>: Время действия паспорта|

=== "400 Некорректный запрос"

    ``` 400 Некорректный запрос

    RESPONSE HEADERS

    | X-Request-Id     | string                         |
    | ----------- | ------------------------------------ |
    | required      | Идентификатор запроса  |

        RESPONSE SCHEMA: application/json

    | Method      | Description                          |
    | ----------- | ------------------------------------ |
    | `errorId` (required)       | string: Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string: Текст ошибки |
    | `errorCode` (required)       | string: Код ошибки |
    | `errorDetails ` (required)       | object: Дополнительные данные об ошибке |
