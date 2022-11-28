
# Сценарий WEB2WEB

Для начала интеграции необходима установка [Tinkoff ID Widget](./widget.md)

![Диаграмма взаимодействия](../img/diagram_tid_w2w.png)

## Процесс авторизации

1. Партнер инициализирует Tinkoff ID Widget, с помощью которого отрисовывается кнопка "Войти с Тинькофф".
2. Пользователь инициирует процесс авторизации, нажимая кнопку "Войти с Тинькофф" на сайте или в приложении партнера.  
3. Партнерский сервис должен сгенерировать параметр ```state``` и связать его с браузером пользователя для защиты от CSRF-атак. Подробнее об этом можно почитать [здесь.](https://datatracker.ietf.org/doc/html/draft-ietf-oauth-security-topics-14#section-4.7)  
4. Инициализация авторизации осуществляется вызовом метода ```GET https://id.tinkoff.ru/auth/authorize``` со следующими параметрами:
* client_id: идентификатор, который вы получили после регистрации
* redirect_uri: ```https://myintegration.ru/auth/complete```
* state: строка из пункта 2
* response_type: ```code```
* scope_parameters (**для Tinkoff Business ID**): URL закодированный json с ИНН и КПП компании клиента. Эти данные необходимы для того, чтобы уметь однозначно определять к какой именно компании давать доступ клиенту. Если у компании клиента нет КПП, передайте вместо него "0". Пример JSON до кодирования:

```
{ 
    "inn" : "9999980892", 
    "kpp" : "999991001" 
} 
```

Пример запроса:

```
GET https://id.tinkoff.ru/auth/authorize?client_id=%client_id%&redirect_uri=https://myintegration.ru/auth/complete&state=ABCxyz&response_type=code&scope_parameters=%20%7B%20%22inn%22%20:%20%227743180892%22,%20%22kpp%22%20:%20%22773101001%22%20%7D
```
5. Отображение экрана аутентификации в Тинькофф. Для веб-приложений это окно id.tinkoff.ru для ввода номера телефона, для мобильных приложений - экран ввода кода.   

6. Пользователь вводит данные для прохождения аутентификации.   

7. Пользователю отображается экран с выбором доступов, которые он предоставляет партнеру:  

**Tinkoff ID**
![](https://business.cdn-tinkoff.ru/static/images/opensme/partner-script.jpg)

**Tinkoff Business ID**
![](https://business.cdn-tinkoff.ru/static/images/opensme/consents-pop-up.jpg)


8. Пользователь нажимает на кнопку "Продолжить", соглашаясь с передачей данных. В зависимости от настроек партнерского приложения, у пользователя есть возможность снятия чекбокса с данными, которые он не готов предоставить.
Если у пользователя напротив всех полей есть включенный чекбокс, то при нажатии "Продолжить", в следующих авторизациях это окно открываться не будет.

9. На ```https://myintegration.ru/auth/complete``` придет запрос вида:  

```
https://myintegration.ru/auth/complete?state=ABCxyz&code=c.1aGiAXX3Ni&session_state=hXXXXXXY3kgs3nx0H3RTj3JzCSrdaqaDhU6lS8XXXXX.i4kl6dsEB1SQogzq0Nj0
```
10. Партнерское приложение должно провалидировать параметр ```state``` для сверки со значением в первоначальном запросе. Если валидация прошла успешно, необходимо забрать значение параметра ```code``` для дальнейшего обмена на токены
   
11. Для получения Access и Refresh токенов необходимо вызвать метод ```POST https://id.tinkoff.ru/auth/token```.

Формат запроса:

* Authorization: Basic, где username и password соответствуют client_id и client_secret, полученным на электронную почту. [Примеры составления в разных языках](https://gist.github.com/brandonmwest/a2632d0a65088a20c00a)
* Content-type: ```application/x-www-form-urlencoded```
* grant_type: ```authorization_code```
* redirect_uri: ```https://myintegration.ru/auth/complete```
* code: код из пункта 9.

Пример запроса:
``` 
curl -X POST \
     https://id.tinkoff.ru/auth/token \
     -H 'Authorization: Basic ' \
     -H 'Content-Type: application/x-www-form-urlencoded' \
     -d 'grant_type=authorization_code&redirect_uri=https://myintegration.ru/auth/complete&code=c.1aGiAXX3Ni'
```
Пример ответа:
```
{
    "access_token": "t.mzucgRIDwalXXX_at2Y2kmJB6yhNAQlWMNucp3w45xMcKknxWyl_XXXXkp5_3Nq8i_UvddDroJvd3elz-QH5hQ",
    "token_type": "Bearer",
    "expires_in": 1791, // Время жизни токена в секундах
    "refresh_token": "LShO9uuXXXXqozxO8WP2eGsJpXXXX-3QBGYUeNzUv4LTtjudU6zPofXbiXXXoznuCOLv6XXXCJn04fsLvsYH2Q"
}
```

12. После получения токена мы рекомендуем проверить, что клиент предоставил нужные доступы, и партнерский сервис правильно передал данные в scope_parameters. Для этого нужно вызвать метод ```POST https://id.tinkoff.ru/auth/introspect``` и проверить в ответе список доступов в поле ```scope```.

Формат запроса:

* Authorization: Basic, где username и password соответствуют client-id и паролю из пункта 2. [Примеры составления в разных языках](https://gist.github.com/brandonmwest/a2632d0a65088a20c00a)
* Content-type: ```application/x-www-form-urlencoded```
* token — тело токена, полученного на предыдущем шаге.

Пример запроса:
``` 
curl -X POST \
     https://id.tinkoff.ru/auth/introspect \
     -H 'Authorization: Basic ' \
     -H 'Content-Type: application/x-www-form-urlencoded' \
     -d 'token=t.mzucgXXXwalMAQ_at2Y2kmJB6yhXXXXXXXucp3w45xMcKknxWyl_8sWkkp5_XXXXX_UvddDroJvd3elz-QH5hQ'
```

**Пример ответа Tinkoff ID**:
```
{
   "active":true,
   "scope":[
      "email",
      "profile",
      "opensme/individual/passport/get",
      "phone",
   ],
   "client_id":"partner",
   "token_type":"access_token",
   "exp":1585728196,
   "iat":1585684996,
   "sub":"2xxxxxxc-8xx6-4xxd-9xx5-bxxxxxxxxxxa",
   "aud":[
     "ibsme",
     "companyInfo"
   ],
   "iss":"https://id.tinkoff.ru/"
}
```
**Пример ответа Tinkoff Business ID**:
```
{
   "active":true,
   "scope":[
      "device_id",
      "opensme/inn/[9999980892]/kpp/[999991001]/payments/draft/create"
      "opensme"
   ],
   "client_id":"opensme",
   "token_type":"access_token",
   "exp":1585728196,
   "iat":1585684996,
   "sub":"2xxxxxxc-8xx6-4xxd-9xx5-bxxxxxxxxxxa",
   "aud":[
     "ibsme",
     "companyInfo"
   ],
   "iss":"https://id.tinkoff.ru/"
}
```

Для каждого метода в Tinkoff API в описании можно найти шаблон доступа, который должен присутствовать в поле ```scope```. По токену, который был получен в предыдущем шаге, для физических лиц можно запросить данные профиля, e-mail, паспорта, а для юридических лиц - создавать черновики платежных поручений компании с ИНН ```9999980892``` и КПП ```999991001```.

**Проверяйте и наличие доступов, и правильность переданных данных.**

13. Сервис партнера обращается к Tinkoff API для получения персональных данных клиентов. Для ознакомления со списком доступных методов перейдите в раздел Методы.

14. Передача персональных данных клиента для заполнения учетной записи и завершения авторизации.

15. Сервис партнера перенаправляет клиента согласно бизнес-логике. При обнаржуении схожести новых учетных данных с существующими рекомендуем ознкомиться с разделом Метчинг учетных записей.