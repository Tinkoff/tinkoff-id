# Партнерский сценарий

## Диаграмма взаимодействия

![Диаграмма взаимодействия](../docs/img/Diagram.png "дига")
# ![Диаграмма взаимодействия](/investAPI/img/order_status_diagram.png "Диаграмма статусов торговых поручений")

## Регистрация

Для начала работы с Tinkoff API в качестве партнера необходимо заполнить заявку на подключение на [этой странице](https://www.tinkoff.ru/business/open-api/). После рассмотрения заявки сотрудниками банка будут высланы ```client_id``` и ```client_secret```на электронную почту, которая была указана в партнерской анкете.

Одним из пунктов партнерской анкеты является указание параметра ```redirect_uri```.  Необходимо создать эндпоинт, доступный по ```redirect_uri```, который заканчивает процесс авторизации путем обмена кода на Access и Refresh токены. В качестве примера, эндпоинт-ссылкой будет  ```https://myintegration.ru/auth/complete```, где ```https://myintegration.ru``` - страница продукта.

## Процесс авторизации

1. Пользователь инициирует процесс авторизации, нажимая кнопку "Войти с Тинькофф" на сайте или в приложении партнера.
2. Партнерский сервис должен сгенерировать параметр ```state``` и связать его с браузером пользователя для защиты от CSRF-атак. Подробнее об этом можно почитать [здесь.](https://datatracker.ietf.org/doc/html/draft-ietf-oauth-security-topics-14#section-4.7)
3. Инициализация авторизации осуществляетяс вызвом метода ```GET https://id.tinkoff.ru/auth/authorize``` со следующими параметрами:
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

4. Отображение экрана аутентификации в Тинькофф. Для веб-приложений это окно id.tinkoff.ru для ввода номера телефона, для мобильных приложений - экран ввода кода. 

5. Пользователь вводит данные для прохождения аутентификации. 

6. Пользователю отображается экран с выбором доступов, которые он предоставляет партнеру:

**Tinkoff ID**
![](https://business.cdn-tinkoff.ru/static/images/opensme/partner-script.jpg)

**Tinkoff Business ID**
![](https://business.cdn-tinkoff.ru/static/images/opensme/consents-pop-up.jpg)


7. Пользователь нажимает на кнопку "Продолжить", соглашаясь с передачей данных. В зависимости от настроек партнерского приложения, у пользователя есть возможность снятия чекбокса с данными, которые он не готов предоставить.
Если у пользователя напротив всех полей есть включенный чекбокс, то при нажатии "Продолжить", в следующих авторизациях это окно открываться не будет.

8. На ```https://myintegration.ru/auth/complete``` придет запрос вида:

```
https://myintegration.ru/auth/complete?state=ABCxyz&code=c.1aGiAXX3Ni&session_state=hXXXXXXY3kgs3nx0H3RTj3JzCSrdaqaDhU6lS8XXXXX.i4kl6dsEB1SQogzq0Nj0
```

9. Партнерское приложение должно провалидировать параметр ```state``` для сверки со значением в первоначальном запросе. Если валидация прошла успешно, необходимо забрать значение параметра ```code``` для дальнейшего обмена на токены
   
10. Для получения Access и Refresh токенов необходимо вызвать метод ```POST https://id.tinkoff.ru/auth/token```.

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

11. После получения токена мы рекомендуем проверить, что клиент предоставил нужные доступы, и партнерский сервис правильно передал данные в scope_parameters. Для этого нужно вызвать метод ```POST https://id.tinkoff.ru/auth/introspect``` и проверить в ответе список доступов в поле ```scope```.

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

12. Сервис партнера обращается к Tinkoff API для получения персональных данных клиентов. Для ознакомления со списком доступных методов перейдите в раздел Методы.

13. Передача персональных данных клиента для заполнения учетной записи и завершения авторизации.

14. Сервис партнера перенаправляет клиента согласно бизнес-логике. При обнаржуении схожести новых учетных данных с существующими рекомендуем ознкомиться с разделом Метчинг учетных записей.

## Мобильная авторизация

Для бесшовного входа в мобильное приложение партнера с Tinkoff ID реализован сценарий App to App. В данном сценарии повторяются шаги, описанные в предыдущем разделе, но необходимо соблюсти следующие требования:

1. В партнерской анкете вас попросят указать ```mobile_redirect_uri```, который является диплинком, ведущим в ваше приложение. Для защиты от потенциальных уязвимостей необходимо использовать кастомную схему URI ```mobile://myintegration``` или ```myservice://authorized```. Обращаем внимание на начало url-адреса, которое не должно принимать вид http/https.
2. В сценарии App to App не используется параметр ```client_secret```. Вместо него необходимо сгенерировать параметр ```code_verifier```, подробно описанный ниже. Также необходимо использовать защиту Proof Key for Code Exchange ([PKCE](https://datatracker.ietf.org/doc/html/rfc7636)) для предотвращения последствий возможного перехвата кода. Данное значение должно быть уникальным для каждого запроса кода авторизации.
3. Использовать готовые средства разработки SDK для соответствующей мобильной платформы.

**Концепция протокола:**

1. Клиент нажимает кнопку "Войти с Тинькофф" в приложении партнера
2. В авторизационном запросе в дополнение к обычным параметрам обязательно передаются параметры ```code_challenge``` и ```code_challenge_method```. Партнерское приложение генерирует параметр ```code_verifier``` и создает его преобразованную версию ```code_challenge```, которая получается с помощью применения преобразования ```code_challenge``` = ```code_challenge_method(code_verifier),``` где ```code_challenge_method``` является трансформирующей функцией. Почитать про хеширование параметра ```code_verifier``` можно [здесь](https://datatracker.ietf.org/doc/html/rfc7636#section-4.1)
3. Мобильное приложение партнера запрашивает код авторизации
4. Клиент отправляет запрос обмена кода на токены, причем в добавление к стандартным параметрам обязательно передает параметр ```code_verifier```, созданный и сохраненный на шаге 2
5. Авторизационный сервер проверяет ```code_verifier``` на соответствие ```code_challenge``` и возвращает токены или отвечает ошибкой
6. Клиент аутентифицируется в мобильном приложении Тинькофф (по уже активной сессии), после чего подтверждает согласие на передачу данных
7. В случае успешного входа мобильное приложение Тинькофф перенаправляет клиента в приложение партнера по адресу, указанному в ```redirect_uri```, в ином случае - партнерский сервис получит ошибку.

**Внимание**: на текущий момент авторизация для юридических лиц c Tinkoff Business ID не доступна на мобильных приложениях.

## SDK
**SDK** - готовые реализации API Tinkoff ID для наиболее распространенных платформ. Использование SDK упрощает разработку и сокращает время на интеграцию ваших мобильных приложений.  
Подробная информация выложена в соответствующие репозитории по ссылкам ниже:
* [Android SDK](https://github.com/tinkoff-mobile-tech/TinkoffID-Android)
* [iOS SDK](https://github.com/tinkoff-mobile-tech/TinkoffID-iOS)

Для ознакомления со стайлгайдами перейдите по [ссылке](https://www.figma.com/file/TsgXOeAqFEePVIosk0W7kP/Tinkoff-ID?node-id=16%3A723).

## Объединение учетных записей
Во избежание дублирования учетных записей пользователя на вашей стороне при использовании разных средств входа рекомендуем реализовать следующий сценарий:
1. При входе пользователя делать проверку по номеру телефона (или ИНН и КПП для юридических лиц) на уже существующую учетную запись,
2. Если учетная запись с указанным номером (или ИНН и КПП для юридических лиц)  уже существует, то уведомить пользователя и предложить объединение.
   Пример реализации:
   ![](https://business.cdn-tinkoff.ru/static/images/opensme/Вход_в_лк.png)
3. При обработке полей объединенных учетных данных пользователя в случае несовпадения рекомендуется отдавать предпочтение Tinkoff ID

Объединение учетных записей позволит:
- Поддерживать качество базы клиентов
- Повысить удобство авторизации клиентов с сохранением программы лояльности
- Обогатить существующие учетные записи актуальными данными.