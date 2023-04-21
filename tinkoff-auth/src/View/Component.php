<?php

namespace TinkoffAuth\View;

abstract class Component
{
    /**
     * @return void
     */
    public function renderInline()
    {
        echo '';
    }

    /**
     * @return string
     */
    public function render()
    {
        return '<div> I\'m component</div>';
    }
}