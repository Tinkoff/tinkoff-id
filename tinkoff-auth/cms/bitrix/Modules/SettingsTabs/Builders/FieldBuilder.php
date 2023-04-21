<?php

namespace TinkoffAuth\CMS\Bitrix\Modules\SettingsTabs\Builders;

class FieldBuilder extends Builder
{
    private $id = '';
    private $label = '';
    private $placeholder = '';
    private $type = 'text';
    private $options = [];

    const TYPE_TEXT     = 'text';
    const TYPE_SELECT   = 'select';
    const TYPE_TEXTAREA = 'textarea';

    public function build()
    {
        $field = '<tr>';
        $field .= $this->buildLabel();
        $field .= $this->buildInput();
        $field .= '</tr>';

        return $field;
    }

    private function buildLabel()
    {
        $label = '<td style="width: 40%;">';
        $label .= '<label for="' . $this->getId() . '">' . $this->getLabel() . '</label>';
        $label .= '</td>';

        return $label;
    }

    private function buildInput()
    {
        $prefix = '<td style="width: 60%">';
        $suffix = '</td>';
        $value  = htmlspecialcharsbx(\COption::GetOptionString($this->getModuleID(), $this->getId(), ''));
        switch ($this->type) {
            case self::TYPE_SELECT:
                $select = '<select name="' . $this->getId() . '">';

                foreach ($this->getOptions() as $index => $label) {
                    $option = '<option ';
                    $option .= 'value="' . $index . '" ';
                    $option .= $index == $value ? 'selected ' : ' ';
                    $option .= '>';
                    $option .= $label;
                    $option .= '</option>';

                    $select .= $option;
                }

                $select .= '</select>';

                return $prefix . $select . $suffix;
            case self::TYPE_TEXTAREA:
                $textarea = '<textarea ';
                $textarea .= 'name="' . $this->getId() . '" ';
                $textarea .= 'id="' . $this->getId() . '"';
                $textarea .= 'placeholder="' . $this->getPlaceholder() . '">';
                $textarea .= $value . '</textarea>';

                return $prefix . $textarea . $suffix;
            default:
                $input = '<input type="text" ';
                $input .= 'value="' . $value . '" ';
                $input .= 'name="' . $this->getId() . '" ';
                $input .= 'id="' . $this->getId() . '"';
                $input .= 'placeholder="' . $this->getPlaceholder() . '"';
                $input .= '>';

                return $prefix . $input . $suffix;
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param mixed $placeholder
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }
}