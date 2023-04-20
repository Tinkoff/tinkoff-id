<?php

namespace TinkoffAuth\View\WordPress\Settings;

use TinkoffAuth\View\Common\OptionSelect as OptionSelectAbstract;

class OptionSelect extends WordPressSettingsComponent
{
    const SELECT_HOOK_VALUES          = [
        'Самостоятельно расположить' => '',
        'Внутри формы регистрации'   => 'woocommerce_login_form',
        'Ниже формы регистрации'     => 'woocommerce_login_form_end',
        'Выше формы регистрации'     => 'woocommerce_login_form_start'
    ];
    const SELECT_HOOK_CHECKOUT_VALUES = [
        'Самостоятельно расположить' => '',
        'Выше деталей заказа'        => 'woocommerce_checkout_billing',
        'Внутри деталей заказа'      => 'woocommerce_checkout_shipping',
        'После деталей заказа'       => 'woocommerce_checkout_after_customer_details',
    ];

    private $values;

    public function __construct($optionName, $values = [])
    {
        parent::__construct($optionName);
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function render()
    {
        if ( ! function_exists('get_option')) {
            return '';
        }
        $option = get_option($this->optionName);

        $selectString = "<select id='{$this->optionName}' name='{$this->optionName}'>";
        foreach ($this->values as $label => $item) {
            $selected     = $option == $item ? 'selected' : '';
            $selectString .= "<option {$selected} value='{$item}'>{$label}</option>";
        }
        $selectString .= "</select>";

        return $selectString;
    }

    /**
     * @return array
     */
    public static function sizes()
    {
        return OptionSelectAbstract::SELECT_BUTTON_SIZE_VALUES;
    }

    /**
     * @return array
     */
    public static function colors()
    {
        return OptionSelectAbstract::SELECT_BUTTON_COLORS_VALUES;
    }

    /**
     * @return array
     */
    public static function languages()
    {
        return OptionSelectAbstract::SELECT_BUTTON_LANG_VALUES;
    }
}