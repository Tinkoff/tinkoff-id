<?php

namespace TinkoffAuth\View\Bitrix;

use TinkoffAuth\View\Common\OptionSelect as OptionSelectAbstract;

class OptionSelect extends BitrixComponent
{
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