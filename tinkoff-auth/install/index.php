<?php

IncludeModuleLangFile(__FILE__);


class tinkoffid extends CModule
{
    var $MODULE_ID = "tinkoffid";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_GROUP_RIGHTS = "Y";

    public function __construct()
    {
        $arModuleVersion = array();

        include(__DIR__ . '/version.php');

        $this->MODULE_VERSION      = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME        = 'TID';
        $this->MODULE_DESCRIPTION = 'Авторизация через Тинькофф ID';

        $this->PARTNER_NAME = "Тинькофф";
        $this->PARTNER_URI  = "https://www.tinkoff.ru/";
    }

    function DoInstall()
    {
        $this->InstallFiles();
        $this->InstallEvents();

        $this->InstallDB(false);
    }

    function DoUninstall()
    {
        $this->UnInstallFiles();
        $this->UnInstallEvents();

        $this->UnInstallDB(false);

        return true;
    }

    function InstallFiles()
    {
        if ($_ENV["COMPUTERNAME"] != 'BX') {
            CopyDirFiles(
                $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $this->MODULE_ID . "/install/components",
                $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components",
                true,
                true
            );
        }

        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function InstallDB()
    {
        RegisterModule($this->MODULE_ID);

        return true;
    }

    function UnInstallFiles($arParams = array())
    {
        \Bitrix\Main\IO\Directory::deleteDirectory($_SERVER['DOCUMENT_ROOT'] . "/bitrix/components/tinkoff/id.button");

        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function UnInstallDB($arParams = array())
    {
        UnRegisterModule($this->MODULE_ID);

        return true;
    }
}
