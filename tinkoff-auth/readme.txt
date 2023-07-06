=== Tinkoff ID ===
Stable tag:        0.2
Contributors:      Tinkoff ID Team
Tested up to:      6.1
WC Tested up to:   7.2
Requires PHP:      5.6
Tags:              tinkoff, тинькофф, auth, авторизация, tinkoff id, social auth, moodmachine
License:           MIT License
License URI:       https://opensource.org/license/mit/

Авторизация через Тинькофф ID для вашего WordPress сайта!

== Description ==

Для начала работы с Tinkoff API необходимо заполнить заявку на
подключение [на этой странице](https://www.tinkoff.ru/business/open-api/).
После рассмотрения заявки сотрудниками банка будут высланы client_id и client_secret на электронную почту,
которая была указана в партнерской анкете.

Одним из пунктов партнерской анкеты является указание параметра redirect_uri.
Необходимо указать ссылку https://example.com/wp-json/tinkoff_auth/v1/callback, заменив example.com на ваш домен.

== Changelog ==

= 0.2 =
* Улучшение совместимости плагина с WordPress

== License ==

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.