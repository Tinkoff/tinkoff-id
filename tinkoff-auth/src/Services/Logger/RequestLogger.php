<?php

namespace TinkoffAuth\Services\Logger;

use TinkoffAuth\Config\TIDModule;
use TinkoffAuth\Services\Http\Response;

class RequestLogger extends AbstractLogger
{
    private $url = '';
    private $response = '';
    private $query = '';
    private $method = 'GET';


    public function __construct()
    {
        $this->setFile('requests.log');
    }

    public static function currentRequest($method = 'GET')
    {
        $url = 'https://';
        $url .= $_SERVER['HTTP_HOST'];
        $url .= $_SERVER['REQUEST_URI'];

        RequestLogger::request($method, $url, $_REQUEST);
    }

    public static function request($method = 'GET', $url = '', $query = '', $response = '')
    {
        if (!TIDModule::getInstance()->isLogEnable()) {
            return;
        }

        $response = is_a($response, Response::class) ? $response->body() : $response;

        $logger = new self();

        $logger->setMethod($method);
        $logger->setUrl($url);
        $logger->setQuery($query);
        $logger->setResponse($response);

        $logger->log();
    }

    public function log($message = '')
    {
        if (!TIDModule::getInstance()->isLogEnable()) {
            return;
        }

        $originalMessage = $message;

        $response = is_array($this->getResponse()) ? json_encode($this->getResponse()) : $this->getResponse();
        $query    = is_array($this->getQuery()) ? json_encode($this->getQuery()) : $this->getQuery();

        $message = "[{$this->getMethod()}] Request log: " . $this->getUrl() . "\n";
        $message .= "Query: $query \n";
        $message .= "Response: $response \n";

        $message .= "Notice: $originalMessage \n\n";

        parent::log($message);
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }
}