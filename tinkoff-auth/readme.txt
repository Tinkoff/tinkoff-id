=== Tinkoff ID ===
Stable tag:        0.2
Contributors:      dmtrbskkv
Tested up to:      6.1
WC Tested up to:   7.2
Requires PHP:      7.4
Tags:              tinkoff, тинькофф, auth, авторизация, tinkoff id, social auth, dmtrbskkv, moodmachine
License:           GPLv2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html

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