<?php

namespace TinkoffAuth\CMS\Bitrix\Modules\SettingsTabs\Builders;

abstract class Builder
{
    protected $moduleID;

    public function __construct($moduleID)
    {
        $this->moduleID = $moduleID;
    }

    /**
     * @return mixed
     */
    public function getModuleID()
    {
        return $this->moduleID;
    }

    /**
     * @param mixed $moduleID
     */
    public function setModuleID($moduleID)
    {
        $this->moduleID = $moduleID;
    }
}