#Получить информацию об активных дебетовых счетах клиента
Необходимо согласие пользователя на получение реквизитов дебетовых счетов. В поле scope у токена должен присутствовать доступ вида ```opensme/individual/accounts/debit/get```

AUTHORIZATIONS: httpAuth

Responses

=== "200  Активные дебетовые счета"

    200  Активные дебетовые счета

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса
    

    RESPONSE SCHEMA: application/json

    | Parameters      | Type     | Description                          |
    | ----------- | --------------- | --------------------- |
    | `accounts`  | Array of objects (DebitAccount) | |
    | `name` (required)  | string | Получатель (ФИО) |
    | `accountNumber` (required)  | string | Счёт получателя платежа |
    | `bank` (required) | object (BankInfo) ||
    | `bik` (required)  | string \d{9} | БИК банка получателя. ВАЖНО: При перечислении налоговых платежей с 01.01.2021 г. нужно указывать новые значения БИК банков получателя. Подробнее: https://spmag.ru/articles/polya-platezhnogo-porucheniya-v-2021-godu-obrazec |
    | `corAccount` (required) | string \d{20} | Корреспондентский счёт банка получателя. ВАЖНО: С 01.01.2021 г., уплачивая налоги, указывается номер счёта банка получателя, входящий в состав единого казначейского счёта (ЕКС), раньше это поле заполнялось нулями. |
    | `name` (required) | string [ 1 .. 255 ] characters | Наименование банка получателя. ВАЖНО: При заполнении платежек на перечисление налогов с 01.01.2021 г. в данном поле после названия банка, через знак «//» следует указывать название счета казначейства. |

 

=== "400"

    400 Некорректный запрос

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |
    | `errorDetails ` (required)       | object | Дополнительные данные об ошибке |

=== "401"

    401 Ошибка аутентификации

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |

=== "403"

    403 Ошибка авторизации

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |


=== "422"

    422 Ошибка при обработке данных

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters    | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |
    | `errorDetails ` (required)       | object | Дополнительные данные об ошибке |

=== "429"

    429 Слишком много запросов

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters     | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |

=== "500"

    500 Ошибка сервера

    RESPONSE HEADERS

    `X-Request-Id` (required) - `string` - Идентификатор запроса

    RESPONSE SCHEMA: application/json

    | Parameters      | Type | Description                          |
    | ----------- | --------- | --------------------------- |
    | `errorId` (required)       | string | Уникальный идентификатор ошибки |
    | `errorMessage` (required)       | string | Текст ошибки |
    | `errorCode` (required)       | string | Код ошибки |

Пример запроса

```GET https://business.tinkoff.ru/openapi/api/v1/individual/accounts/debit```

Пример ответа

```
{
  "accounts": [
    {
      "name": "Иванов Иван Иванович",
      "accountNumber": "40802123456789012345",
      "bank": {
        "bik": "044525974",
        "corAccount": "30101810145250000974",
        "name": "АО \"ТИНЬКОФФ БАНК\""
      }
    }
  ]
}
```
