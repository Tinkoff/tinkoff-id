
# Сценарий APP2WEB через webview

## Для авторизации в приложении с использованием компонента WebView в Tinkoff ID реализован сценарий APP to WEB.

1. Партнер инициализирует запуск WebView с кнопкой "Войти в Тинькофф ID"
2. Пользователь инициирует процесс авторизации, нажимая кнопку "Войти с Тинькофф" на сайте или в приложении партнера.
3. Партнерский сервис должен сгенерировать параметр ```code_verifier``` и ```code_challenge_method```, создает его преобразованную версию ```code_challenge```, которая получается с помощью применения преобразования ```code_challenge = code_challenge_method(code_verifier)```, где ```code_challenge_method``` является трансформирующей функцией.

  - Почитать про хеширование параметра ```code_verifier``` можно [здесь](https://datatracker.ietf.org/doc/html/rfc7636#section-4.1).
  - Необходимо использовать защиту Proof Key for Code Exchange ([PKCE](https://datatracker.ietf.org/doc/html/rfc7636)) для предотвращения последствий возможного перехвата кода, данное значение должно быть уникальным для каждого запроса кода авторизации.
  - Пример генератора: https://tonyxu-io.github.io/pkce-generator/
  - Требуемая генерация: "base64_url(SHA256(code_verifier))"
4. Инициализация авторизации осуществляется вызовом метода GET ```https://id.tinkoff.ru/auth/authorize``` со следующими параметрами:

  - ```client_id```: идентификатор, который вы получили после регистрации
  - ```mobile_redirect_url``` (app link в приложение, указанные в анкете) 
  - ```code_verifier``` из пункта 3 
  - ```response_type: code```
  - ```response_mode=query```

Пример запроса:

```html
GET https://id.tinkoff.ru/auth/authorize?client_id=%client_id%&redirect_uri=https://myintegration.ru/auth/complete&code_challenge={codeChallenge}&code_challenge_method=S256&response_type=code
```

5. Отображение экрана аутентификации в Тинькофф  id.tinkoff.ru для ввода номера телефона.
6. Пользователь вводит данные для прохождения аутентификации.
7. Пользователь нажимает на кнопку "Продолжить", соглашаясь с передачей данных. В зависимости от настроек партнерского приложения, у пользователя есть возможность снятия чекбокса с данными, которые он не готов предоставить. Если у пользователя напротив всех полей есть включенный чекбокс, то при нажатии "Продолжить", в следующих авторизациях это окно открываться не будет.
8. На ```https://myintegration.ru/auth/complete``` придет запрос вида:

```html
https://myintegration.ru/auth/complete?code_challenge={codeChallenge}&code_challenge_method=S256&code=c.1aGiAXX3Ni&session_state=hXXXXXXY3kgs3nx0H3RTj3JzCSrdaqaDhU6lS8XXXXX.i4kl6dsEB1SQogzq00
```

9. По app link происходит переход в партнерское приложение с параметром ```code```
10. Партнерское приложение должно провалидировать параметр ```code_verifier```  для сверки со значением в первоначальном запросе, если валидация прошла успешно, необходимо забрать значение параметра ```code``` для дальнейшего обмена на токены.
11. Для получения Access и Refresh токенов необходимо вызвать метод POST ```https://id.tinkoff.ru/auth/token```. 
Формат запроса:

  - Authorization: Basic, где username  соответствуют client_id  полученному на электронную почту. [Примеры составления в разных языках](https://gist.github.com/brandonmwest/a2632d0a65088a20c00a)
  - Content-type: ```application/x-www-form-urlencoded```
  - grant_type: ```authorization_code```
  - redirect_uri: ```mobile_redirect_url``` (тот, который был направлен в ```authorize``` )
  - ```code_verifier```
12. Авторизационный сервер проверяет ```code_verifier``` на соответствие ```code_challenge``` и возвращает токены или отвечает ошибкой.

Пример запроса на получение токена:

```html
curl -X POST \
     https://id.tinkoff.ru/auth/token \
     -H 'Authorization: Basic ' \
     -H 'Content-Type: application/x-www-form-urlencoded' \
     -d 'grant_type=authorization_code&redirect_uri=https://myintegration.ru/auth/complete&code=c.1aGiAXX3Ni'
```

Пример ответа:

```html

{
    "access_token": "t.mzucgRIDwalXXX_at2Y2kmJB6yhNAQlWMNucp3w45xMcKknxWyl_XXXXkp5_3Nq8i_UvddDroJvd3elz-QH5hQ",
    "token_type": "Bearer",
    "expires_in": 1791, // Время жизни токена в секундах
    "refresh_token": "LShO9uuXXXXqozxO8WP2eGsJpXXXX-3QBGYUeNzUv4LTtjudU6zPofXbiXXXoznuCOLv6XXXCJn04fsLvsYH2Q"
}
```