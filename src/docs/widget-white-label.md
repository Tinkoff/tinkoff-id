# Tinkoff ID Widget White Label

## Принцип работы

По нажатию на кнопку (например "Войти") виджет перехватит событие формы с введенным номером телефона. Далее появится форма Tinkoff ID с вводом кода, который получил пользователь по указанному номеру телефона.

## Подключение библиотеки на сайте
Для подключения на сайте необходимо вставить в блок head следующий скрипт:
```html
<script src="https://business.cdn-tinkoff.ru/static/projects/tinkoff-id/widget.js"></script>
```

Пример инициализации скрипта:

```html
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo</title>

    <script src="https://business.cdn-tinkoff.ru/static/projects/tinkoff-id/widget.js"></script>
  </head>
  <body>
		<form id="login-form">
  			<input type="text" name="phone" id="phone-input">
  			<button type="submit" id="login-button">Войти</button>
		</form>

		<script>
  			const tidSdk = new TidSDK({
      			redirectUri: 'https://mysite.ru/auth/success',
      			responseType: 'code',
      			scopeParameters: '',
      			clientId: 'XXXX',
      			state: 'XXXX'
    		});

  			tidSdk.addWL({
    			target: '_blank',
    			input: '#phone-input',
    			actionElement: '#login-form'
  			});
		</script>
	</body>
</html>
```

## Описание параметров
### Auth Params
  - **redirectUri** `string` - Uri, на который будет перенаправлен клиент после завершения авторизационного диалога
  - **responseType** `string` - Определяет какой авторизационный процесс будет запущен и какие параметры будут переданы по завершению авторизации
  - **scopeParameters** `string` (необязательный параметр) - Набор данных, указанный партнером в технической анкете
  - **clientId** `string` - Идентификатор клиента (приложения)
  - **state** `string` - Строка, генерируемая на стороне клиента для связи контекста запуска авторизации с завершением

### UI Params
  - **input** `string` | `HTMLInputElement` - input элемент, в котором содержится номер телефона. Пример: `#input`, `.input` или же сам элемент
  - **actionElement** `string` | `HTMLElement` (необязательный параметр; если параметр не передан, то событие повесится на элемент из параметр **input**) - элемент, на который вешается событие отправки номера телефона. Если передана форма, то повесится событие submit, в противном случае будет событие click
  - **target** `_parent` | `_self` | `_blank` | `_top` (необязательный параметр, по умолчанию используется _blank) - определеяет, в каком окне будет открываться форма авторизации. Если необходимо открывать окно вместо текущей вкладки, используйте `_self`
  - **redirectUri** `string` (необязательный параметр) - в случае, если redirectUri зависит от страницы, на которой находится пользователь, при вызове метода addWL можно передать новый redirectUri
  