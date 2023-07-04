<?php

namespace TinkoffAuth\Services\Logger;

use TinkoffAuth\Config\TIDModule;

abstract class AbstractLogger
{
    private $file = '';

    public function log($message = '')
    {
        if (!TIDModule::getInstance()->isLogEnable()) {
            return;
        }

        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('Europe/Moscow'));
        $message = '[' . $datetime->format('d.m.Y H:i:s') . ']' . $message . "\n";

        @file_put_contents($this->getFilePath(), $message, FILE_APPEND);
    }

    public function getFilePath()
    {
        $dir  = __DIR__ . '/../../../storage/log';
        $file = $this->file ? $this->file : 'default.log';
        return $dir . '/' . $file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }
}