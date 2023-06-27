<?php

namespace TinkoffAuth\View\WordPress;

use TinkoffAuth\View\Component;

class ButtonLoader extends Component
{
    public static $jsInjected = false;

    public function render()
    {
        $html = "<div class='tid-xhr'></div>";

        if (!self::$jsInjected) {
            self::$jsInjected = true;

            $html .= "<script> ";
            $html .= "xhr = new XMLHttpRequest();";
            $html .= "xhr.open('GET', '/wp-json/tinkoff_auth/v1/button');";
            $html .= "xhr.send();";
            $html .= "xhr.onload = function(){";
            $html .= "document.querySelectorAll('.tid-xhr').forEach(function(node){node.innerHTML = JSON.parse(xhr.response).button;});";
            $html .= "}";
            $html .= "</script>";
        }

        return $html;
    }
}