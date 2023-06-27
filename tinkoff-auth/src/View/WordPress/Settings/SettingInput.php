<?php

namespace TinkoffAuth\View\WordPress\Settings;

class SettingInput extends WordPressSettingsComponent
{

    /**
     * @return string
     */
    public function render()
    {
        if (!function_exists('get_option')) {
            return '';
        }

        $option = get_option($this->optionName);

        $inputString = "<input name='{$this->optionName}'";
        $inputString .= "type='text' id='{$this->optionName}' class='regular-text'";
        $inputString .= "value='{$option}'>";

        return $inputString;
    }

}