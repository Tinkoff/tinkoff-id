
# Tinkoff ID Widget

## Рекомендации по интеграции Tinkoff ID
Прежде, чем преступить к добавлению кнопки на сайте, рекомендуем ознакомиться с [Рекомендации по интеграции Tinkoff ID](https://www.tinkoff.ru/corporate/business-solutions/open-api/tinkoff-id/integration/instruction/)

## Подключение библиотеки на сайте
Для подключения на сайте необходимо вставить в блок **head** следующий скрипт:
```html
<script src="https://business.cdn-tinkoff.ru/static/projects/tinkoff-id/widget/bundle.js"></script>
```

## Пример инициализации скрипта
```javascript
const authParams = {
  redirectUri: 'https://mysite.ru/auth/success',
  responseType: 'code',
  scopeParameters: '',
  clientId: 'XXXX',
  state: 'XXXX'
}

const uiParams = {
  container: '#container-for-tid-button',
  size: 'm',
  color: 'primary',
  text: 'Tinkoff',
}

const tidSdk = new TidSDK(authParams);

tidSdk.add(uiParams);
```

![Результат](../img/tinkoff_id_button.png)


## Описание параметров
### Auth Params
  - **redirectUri** `string` - Uri, на который будет перенаправлен клиент после завершения авторизационного диалога
  - **responseType** `string` - Определяет какой авторизационный процесс будет запущен и какие параметры будут переданы по завершению авторизации
  - **scopeParameters** `string` (необязательный параметр) - Набор данных, указанный партнером в технической анкете
  - **clientId** `string` - Идентификатор клиента (приложения)
  - **state** `string` - Строка, генерируемая на стороне клиента для связи контекста запуска авторизации с завершением

### UI Params
  - **container** `string | HTMLElement` - элемент-контейнер, внутри которого располагается кнопка. Пример: `#container`, `.container` или же сам элемент
  - **size** `string` - размер кнопки. Поддерживаются следующие размеры: `xs`, `s`, `m` и `l`
  - **color** `string` - цвет кнопки. Поддерживаются следующие цвета: `primary`, `black`, `grey` и `business`
  - **text** `string` (необязательный параметр) - текст слева от логотипа. По умолчанию используется "Войти с Тинькофф"

## FAQ
### Кнопка отображается не так, как хотелось бы
Для кастомизации кнопки под свой дизайн, можно переопределить стили кнопки. Для этого в css файле добавьте соответствующие классы.
Например:
```css
.tid-4PNRE-button-primary {
  background-color: red;
}
```
поменяет цвет кнопки на красный