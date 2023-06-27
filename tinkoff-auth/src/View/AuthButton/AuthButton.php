<?php

namespace TinkoffAuth\View\AuthButton;

use TinkoffAuth\View\Component;

class AuthButton extends Component
{
    const BUTTON_SIZE_DEFAULT = 'default';
    const BUTTON_SIZE_SMALL = 'small';
    const BUTTON_SIZE_LARGE = 'large';

    const BUTTON_COLOR_YELLOW = 'yellow';
    const BUTTON_COLOR_WHITE = 'white';
    const BUTTON_COLOR_BLACK = 'black';

    const BUTTON_LANG_EN = 'en';
    const BUTTON_LANG_RU = 'ru';

    const AVAILABLE_SIZES = [
        self::BUTTON_SIZE_DEFAULT,
        self::BUTTON_SIZE_SMALL,
        self::BUTTON_SIZE_LARGE,
    ];

    const AVAILABLE_COLORS = [
        self::BUTTON_COLOR_YELLOW,
        self::BUTTON_COLOR_WHITE,
        self::BUTTON_COLOR_BLACK,
    ];

    const AVAILABLE_LANG = [
        self::BUTTON_LANG_EN,
        self::BUTTON_LANG_RU,
    ];

    private static $styleInjected = false;

    private $link;
    private $buttonSize = null;
    private $buttonColor = null;
    private $lang = null;

    public function __construct($link, $buttonSize = null, $buttonColor = null, $lang = null)
    {
        $this->link = $link;
        if (in_array($buttonSize, self::AVAILABLE_SIZES)) {
            $this->buttonSize = $buttonSize;
        }
        if (in_array($buttonColor, self::AVAILABLE_COLORS)) {
            $this->buttonColor = $buttonColor;
        }
        if (in_array($lang, self::AVAILABLE_LANG)) {
            $this->lang = $lang;
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        $color = isset($this->buttonColor) && $this->buttonColor ? $this->buttonColor : self::BUTTON_COLOR_YELLOW;
        $size  = isset($this->buttonSize) && $this->buttonSize ? $this->buttonSize : self::BUTTON_SIZE_DEFAULT;
        $lang  = isset($this->lang) && $this->lang ? $this->lang : self::BUTTON_LANG_RU;

        $string   = $this->styles();
        $filename = $lang . '-' . $color . '-' . $size . '.svg';
        $filepath = __DIR__ . '/SVG/' . $filename;
        if (!file_exists($filepath)) {
            return '';
        }

        return $string . "<a href='{$this->link}'>" . file_get_contents($filepath) . '</a>';
    }

    private function styles()
    {
        if (self::$styleInjected) {
            return '';
        }
        $styles = file_get_contents(__DIR__ . '/AuthButton.css');
        $styles = "<style>{$styles}</style>";

        self::$styleInjected = true;

        return $styles;
    }
}