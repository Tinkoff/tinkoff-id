<?php

namespace TinkoffAuth\CMS\Bitrix\Modules\SettingsTabs;

class ProcessResponse
{
    public static function process($moduleID, $fields, $globals)
    {
        list($Update, $Apply, $RestoreDefaults) = $globals;

        $validateString = $Update . $Apply . $RestoreDefaults;
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($validateString) > 0 && check_bitrix_sessid()) {
            // Сбрасываем значения по умолчанию
            if ($RestoreDefaults) {
                \COption::RemoveOption(TINKOFF_AUTH_FIELD_CLIENT_ID);
                \COption::RemoveOption(TINKOFF_AUTH_FIELD_CLIENT_SECRET);
            } else {
                // Сохранение значений полей
                foreach ($fields as $fieldID) {
                    $value = isset($_REQUEST[$fieldID]) && $_REQUEST[$fieldID] ? $_REQUEST[$fieldID] : '';
                    \COption::SetOptionString($moduleID, $fieldID, $value);
                }
            }
        }
    }
}