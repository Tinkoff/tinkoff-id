<?php

namespace TinkoffAuth\View\WordPress\Settings;

class CheckboxInput extends WordPressSettingsComponent
{
    /**
     * @return string
     */
    public function render()
    {
        $checked = get_option($this->optionName) ? 'checked' : '';

        $checkboxString = "<label for='{$this->optionName}'>";
        $checkboxString .= "<input name='{$this->optionName}' type='checkbox' id='{$this->optionName}' {$checked}>";
        $checkboxString .= "Включить</label>";

        return $checkboxString;
    }

}