<?php

namespace RestiveSDK\Clients;

use GuzzleHttp\Client as Guzzle;

class AbstractClient
{
    protected $domain = '';

    protected $baseUrl = '';

    protected $restiveUrl = '';

    public function __construct(Guzzle $guzzle, $restiveUrl = '')
    {
        $this->guzzle = $guzzle;
        $this->restiveUrl = $restiveUrl;
    }

    public function call($method = 'GET')
    {
        $method = strtoupper($method);
        $uri = $this->domain. $this->baseUrl . '?' . $this->restiveUrl;
        $response = $this->guzzle->request($method, $uri);
        return $response;
    }
}