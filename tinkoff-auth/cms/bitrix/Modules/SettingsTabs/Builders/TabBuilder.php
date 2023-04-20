<?php

namespace TinkoffAuth\CMS\Bitrix\Modules\SettingsTabs\Builders;

class TabBuilder extends Builder
{
    private $id;
    private $name;
    private $headline;
    /** @var FieldBuilder[] */
    private $fields = [];

    public function build()
    {
        $tab = '';
        foreach ($this->fields as $field) {
            $tab .= $field->build();
        }

        echo $tab;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @param mixed $headline
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    }

    public function addField($field)
    {
        $this->fields[] = $field;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
}