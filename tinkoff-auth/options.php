<?php

use TinkoffAuth\CMS\Bitrix\Modules\SettingsTabs\Builders\FieldBuilder;
use TinkoffAuth\CMS\Bitrix\Modules\SettingsTabs\Builders\SettingsTabsBuilder;
use TinkoffAuth\CMS\Bitrix\Modules\SettingsTabs\Builders\TabBuilder;
use TinkoffAuth\CMS\Bitrix\Modules\SettingsTabs\ProcessResponse;
use TinkoffAuth\View\Bitrix\OptionSelect;

if ( ! CModule::IncludeModule("tinkoffid")) {
    return;
}

$moduleID = 'tinkoffid';
$right    = $APPLICATION->GetGroupRight("subscribe");
if ($right == "D") {
    $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
}

ProcessResponse::process($moduleID, [
    TINKOFF_AUTH_FIELD_CLIENT_ID,
    TINKOFF_AUTH_FIELD_CLIENT_SECRET,
    TINKOFF_AUTH_FIELD_BLOCKED_GROUPS,
    TINKOFF_AUTH_FIELD_BUTTON_SIZE,
    TINKOFF_AUTH_FIELD_BUTTON_COLOR,
    TINKOFF_AUTH_FIELD_BUTTON_LANG,
], [
    $save,
    $apply,
    $RestoreDefaults
]);

$tabMain = new TabBuilder($moduleID);
$tabMain->setId('main');
$tabMain->setName('Основные');
$tabMain->setHeadline('Настройки Tinkoff ID');

$fieldClientID = new FieldBuilder($moduleID);
$fieldClientID->setId(TINKOFF_AUTH_FIELD_CLIENT_ID);
$fieldClientID->setLabel('Client ID');
$fieldClientID->setType(FieldBuilder::TYPE_TEXT);
$fieldClientID->setPlaceholder('Введите Client ID интеграции');
$tabMain->addField($fieldClientID);

$fieldClientSecret = new FieldBuilder($moduleID);
$fieldClientSecret->setId(TINKOFF_AUTH_FIELD_CLIENT_SECRET);
$fieldClientSecret->setLabel('Client Secret');
$fieldClientSecret->setType(FieldBuilder::TYPE_TEXT);
$fieldClientSecret->setPlaceholder('Введите Client Secret интеграции');
$tabMain->addField($fieldClientSecret);

$fieldBlockedGroups = new FieldBuilder($moduleID);
$fieldBlockedGroups->setId(TINKOFF_AUTH_FIELD_BLOCKED_GROUPS);
$fieldBlockedGroups->setLabel('Запретить авторизацию');
$fieldBlockedGroups->setType(FieldBuilder::TYPE_SELECT);
$fieldBlockedGroups->setOptions(OptionSelect::groups());
$fieldBlockedGroups->setMultiple(true);
$tabMain->addField($fieldBlockedGroups);

$tabVisual = new TabBuilder($moduleID);
$tabVisual->setId('visual');
$tabVisual->setName('Оформление');
$tabVisual->setHeadline('Настройки кнопки Tinkoff ID');

$fieldSize = new FieldBuilder($moduleID);
$fieldSize->setId(TINKOFF_AUTH_FIELD_BUTTON_SIZE);
$fieldSize->setLabel('Размер кнопки');
$fieldSize->setType(FieldBuilder::TYPE_SELECT);
$fieldSize->setOptions(OptionSelect::sizes());
$tabVisual->addField($fieldSize);

$fieldColor = new FieldBuilder($moduleID);
$fieldColor->setId(TINKOFF_AUTH_FIELD_BUTTON_COLOR);
$fieldColor->setLabel('Цвет кнопки');
$fieldColor->setType(FieldBuilder::TYPE_SELECT);
$fieldColor->setOptions(OptionSelect::colors());
$tabVisual->addField($fieldColor);

$fieldLang = new FieldBuilder($moduleID);
$fieldLang->setId(TINKOFF_AUTH_FIELD_BUTTON_LANG);
$fieldLang->setLabel('Язык кнопки');
$fieldLang->setType(FieldBuilder::TYPE_SELECT);
$fieldLang->setOptions(OptionSelect::languages());
$tabVisual->addField($fieldLang);

$settingsTabs = new SettingsTabsBuilder($moduleID);
$settingsTabs->setHeadline('Настройки модуля Tinkoff ID');
$settingsTabs->addTab($tabMain);
$settingsTabs->addTab($tabVisual);

$settingsTabs->build($APPLICATION);