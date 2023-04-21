<?php

namespace TinkoffAuth\Mediator;

abstract class Mediator
{
    protected $status = false;
    protected $message = '';
    protected $payload = null;

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param bool $status
     *
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed|null
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param $payload
     *
     * @return void
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }
}