<?php

namespace TinkoffAuth\View\WordPress\Settings;

use TinkoffAuth\View\Component;

abstract class WordPressSettingsComponent extends Component
{
    /**
     * @var string
     */
    protected $optionName;

    public function __construct($optionName)
    {
        $this->optionName = $optionName;
    }
}