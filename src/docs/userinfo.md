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

```
curl -v --location --request POST ‘https://id.tinkoff.ru/userinfo/userinfo’ \
--header ‘Authorization: Bearer t.***********************************************************************’ \
--header ‘Content-Type: application/x-www-form-urlencoded’ \
--data-urlencode ‘client_id=*****’ \
--data-urlencode ‘client_secret=**************************’ 
```

Пример ответа

```
{
 "email": "tinkoff@mail.ru",
 "email_verified": false,
 "family_name": "Иванов",
 "birthdate": "2000-01-01",
 "sub": "923d4812-148c-45v4-a56b-eed15cdd2857",
 "name": "Иванов Олег",
 "gender": "male"
 "phone_number": "+79998887766",
 "phone_number_verified" : true,
 "middle_name": "Юрьевич",
 "given_name": "Олег"
}
```




