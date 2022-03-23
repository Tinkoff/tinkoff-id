# Работа с полученными токенами

## Работа с Access токеном

Для того, чтобы использовать Access Token, добавьте заголовок Authorization со значением ```Bearer %token%```.

Пример использования:
```
curl -X GET \
  https://business.tinkoff.ru/openapi/api/v1/company \
  -H 'Authorization: Bearer t.L4c14_rCVNbXueBPC2dFJ9fNqk9BnQuRGGz2fztHpwlFGLYxWNfTI0u_CZPEd0dMWCt0kA9P6TUgToC2_BRT7g' \
  -H 'Content-Type: application/json' \
```


## Работа с Refresh токеном

Для того, чтобы, имея Refresh Token, получить новые Access и Refresh токены, нужно вызвать метод ```POST https://id.tinkoff.ru/auth/token```.

Формат запроса: 

* Authorization: Basic, где username и password соответствуют client-id, которые были получены после регистрации.  [Примеры составления в разных языках](https://gist.github.com/brandonmwest/a2632d0a65088a20c00a)
* Content-type: ```application/x-www-form-urlencoded```
* grant_type: ```refresh_token```
* refresh_token: в это поле передать ваш токен.

Пример запроса:
```
curl -X POST \
  https://id.tinkoff.ru/auth/token \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -d 'grant_type=refresh_token&refresh_token=LShO9uuTkeWqozxO8WP2eGsJpLBQQ-3QBGYUeNzUv4LTtjudU6zPofXbiMwToznuCOLv65tpCJn04fsLvsYH2Q'
```

Пример ответа:
```
{
    "access_token": "t.mzucgRIDwalMAQ_at2Y2kmJB6yhNAQlWMNucp3w45xMcKknxWyl_8sWkkp5_3Nq8i_UvddDroJvd3elz-QH5hQ",
    "token_type": "Bearer",
    "expires_in": 1791, //Время жизни токена в секундах
    "refresh_token": "WvcsjowaPtv1t8r4KDeTyRk89NsSK0lTczBt8CqUSHyx3Xbh7SaWAsGhNIBEHBwqng8l2UZtBFeJCQL0GQrfoG"
}
```

# Инвалидация Refresh token
Убедитесь, что ваши обращения выполняются с актуальным Refresh token.
Если была получена ошибка ```invalid_grant```, то это значит, что Refresh token перестал быть актуальным.
После получения ошибки ```invalid_grant``` важно не производить дальнейшие вызовы обмена токена, так как данный токен уже инвалидирован.
Для дальнейшей работы пользователю нужно повторно пройти авторизацию.

Refresh token может перестать быть актуальным в следующих случаях:
* Пользователь деактивировал авторизацию на странице [Настроек безопасности]([https://id.tinkoff.ru/account/security])
* Пользователь перестал быть клиентом Тинькофф
* Пользователь завершил активные сессии для всех устройств
* Блокировка учетной записи пользователя
* Осуществлен отзыв токенов методом auth/revoke.

## Метод отзыва токенов
Данный метод позволяет инвалидировать Refresh или Access token. Если пользователь принял решение отозвать авторизацию, то мы рекомендуем инвалидировать Refresh token.
Для того чтобы отозвать полученные токены нужно вызвать метод ```POST [https://id.tinkoff.ru/auth/revoke] ```
Формат запроса:

- Authorization: Basic, где username и password соответствуют client-id, которые были получены после регистрации.
- Content-type: application/x-www-form-urlencoded
- token: токен, который нужно отозвать.
- token_type_hint: необязательная подсказка о типе токена, позволяющая ускорить поиск токена для сервера. Может принимать значения ```access_token```, ```refresh_token```

Пример запроса:
```sh
'curl -X POST \ [https://id.tinkoff.ru/auth/revoke] \ -H 'Authorization: Basic ' \ -H 'Content-Type: application/x-www-form-urlencoded' \ -d 'token=LShO9uuTkeWqozxO8WP2eGsJpLBQQ-3QBGYUeNzUv4LTtjudU6zPofXbiMwToznuCOLv65tpCJn04fsLvsYH2Q&token_type_hint=refresh_token
```
