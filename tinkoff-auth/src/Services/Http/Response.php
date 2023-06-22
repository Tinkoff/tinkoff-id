<?php

namespace TinkoffAuth\Services\Http;

class Response
{
    /**
     * @var string
     */
    private $headersRaw = '';
    /**
     * @var string
     */
    private $bodyRaw = '';

    /**
     * @var array
     */
    private $bodyJSON = [];
    /**
     * @var array
     */
    private $headers = [];

    public function setBody($body)
    {
        $this->bodyRaw  = $body;
        $this->bodyJSON = $this->jsonDecodeBody($body);
    }

    public function setHeaders($headers)
    {
        if (is_array($headers)) {
            $this->headers = $headers;
        }
        if (is_string($headers)) {
            $this->headersRaw = $headers;
            $this->headers    = $this->parseHeaders($headers);
        }
    }

    /**
     * @return array
     */
    public function json()
    {
        return $this->bodyJSON;
    }

    /**
     * @return string
     */
    public function body()
    {
        return $this->bodyRaw;
    }

    /**
     * @return array
     */
    public function headers()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function headersRaw()
    {
        return $this->headersRaw;
    }

    /**
     * @param $headers
     *
     * @return array
     */
    private function parseHeaders($headers)
    {
        if (!is_string($headers)) {
            return [];
        }

        $headersArray = [];
        $headers      = explode("\n", $headers);
        foreach ($headers as $header) {
            if (strpos($header, 'HTTP/') !== false) {
                continue;
            }

            $headerPieces = explode(':', $header);
            if (count($headerPieces) !== 2) {
                continue;
            }

            $headersArray[$headerPieces[0]] = $headerPieces[1];
        }

        return $headersArray;
    }

    /**
     * @param $body
     *
     * @return array
     */
    private function jsonDecodeBody($body)
    {
        $canBeDecoded = json_decode($body);
        if (!$canBeDecoded) {
            return [];
        }

        return json_decode($body, true);
    }
}