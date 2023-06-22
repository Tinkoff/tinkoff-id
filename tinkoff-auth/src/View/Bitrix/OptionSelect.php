<?php

namespace TinkoffAuth\View\Bitrix;

use TinkoffAuth\View\AuthButton\AuthButton;
use TinkoffAuth\View\Common\OptionSelect as OptionSelectAbstract;
use CGroup;

class OptionSelect extends BitrixComponent
{
    public static function groups()
    {
        $groupsResult = [];
        $groups       = CGroup::GetList();
        while ($group = $groups->Fetch()) {
            $id = $group['ID'];
            if ($id === "1" || $id === "2") {
                continue;
            }

            $groupsResult[$group['ID']] = $group['NAME'];
        }
        return $groupsResult;
    }

    /**
     * @return array
     */
    public static function sizes()
    {
        return array_flip(OptionSelectAbstract::SELECT_BUTTON_SIZE_VALUES);
    }

    /**
     * @return array
     */
    public static function colors()
    {
        return array_flip(OptionSelectAbstract::SELECT_BUTTON_COLORS_VALUES);
    }

    /**
     * @return array
     */
    public static function languages()
    {
        return array_flip(OptionSelectAbstract::SELECT_BUTTON_LANG_VALUES);
    }
}