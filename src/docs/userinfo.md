#Получение учетных данных

Необходимо согласие пользователя на предоставление следующих данных: "Полное имя", "E-mail", "Номер телефона". Перечень scopes у токена для получения учетных данных:

* profile
* phone
* email

Входные параметры:

* заголовок `Authorization = Bearer \{access_token}`

* поля формы `application/x-www-form-urlencoded`:

** `client_id` - id клиента

** `client_secret` - пароль клиента

Формат ответа
Ответ метода представлен в формате `application/json`. Поля json документа (зависит от scope, не фиксированный список):

* `sub` - идентификатор авторизированного пользователя

* `name` - фамилия, имя

* `gender` - пол

* `birthdate` - дата рождения в формате yyyy-mm-dd

* `family_name` - фамилия

* `given_name` - имя

* `middle_name` - отчество

* `phone_number` - телефон в формате +(международный идентификатор страны)(номер абонента)

* `email` - почтовый адрес

Пример запроса

```POST https://id.tinkoff.ru/userinfo/userinfo```

Пример ответа

```
{
 "email": "tinkoff@mail.ru",
 "family_name": "Иванов",
 "birthdate": "2000-01-01",
 "sub": "923d4812-148c-45v4-a56b-eed15cdd2857",
 "name": "Иванов Олег",
 "phone_number": "+79998887766",
 "middle_name": "Юрьевич",
 "given_name": "Олег",
}
```

#Получить паспортные данные

Необходимо согласие пользователя на получение информации о паспортных данных. В поле scope у токена должен присутствовать доступ вида ```opensme/individual/passport/get```

AUTHORIZATIONS: httpAuth


Responses

=== "200 Паспорт гражданина РФ"

    ``` 200 Паспорт гражданина РФ
    #include <stdio.h>

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
    #include <iostream>

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



