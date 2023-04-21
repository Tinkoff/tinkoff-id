<?php

namespace TinkoffAuth\View\Common;

use TinkoffAuth\View\AuthButton\AuthButton;

abstract class OptionSelect
{
    const SELECT_BUTTON_SIZE_VALUES   = [
        'Стандартная кнопка' => AuthButton::BUTTON_SIZE_DEFAULT,
        'Большая кнопка'     => AuthButton::BUTTON_SIZE_LARGE,
        'Маленькая кнопка'   => AuthButton::BUTTON_SIZE_SMALL
    ];
    const SELECT_BUTTON_COLORS_VALUES = [
        'Желтая кнопка' => AuthButton::BUTTON_COLOR_YELLOW,
        'Белая кнопка'  => AuthButton::BUTTON_COLOR_WHITE,
        'Черная кнопка' => AuthButton::BUTTON_COLOR_BLACK
    ];
    const SELECT_BUTTON_LANG_VALUES   = [
        'Русский'    => AuthButton::BUTTON_LANG_RU,
        'Английский' => AuthButton::BUTTON_LANG_EN,
    ];
}