## Глоссарий

### Технические термины

* **Access Token** — токен, который дает доступ до методов Tinkoff API. Для партнерского сценария, токен будет активен (т.е. по нему можно будет вызывать методы) 30 минут: потом его надо будет переполучить. Для сценария "Селф-Сервис" токен будет активен 1 год.
* **Refresh Token** — токен, активный 1 год, который дает возможность получить новый Access Token, если он устарел, чтобы восстановить доступ до методов Tinkoff API. Требуется для фонового обмена данными без участия клиента.
* **redirect_uri** — uri для перехода, который вы указываете при регистрации партнера. На него будет произведен редирект для получения Access и Refresh токенов. Подробнее про формат запросов, который должен обрабатывать эндпоинт на этом uri, можно почитать [здесь.](#section/Partnerskij-scenarij/Opisanie-processa-avtorizacii)  
* **client_id** - уникальный идентификатор партнера, которые вы получаете при регистрации  
* **scope** - механизм, [используемый в OAuth 2.0](https://oauth.net/2/scope/), который ограничивает права доступа вашего приложения к пользовательским данным. Выпущенный в личном кабинете токен будет ограничен выбранными в меню доступами.