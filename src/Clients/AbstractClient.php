<?php

namespace RestiveSDK\Clients;

use GuzzleHttp\Client as Guzzle;

class AbstractClient
{
    protected $domain = '';

    protected $baseUrl = '';

    public function __construct(Guzzle $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function call($method = 'GET', $url)
    {
        $method = strtoupper($method);
        $uri = $this->domain . $this->baseUrl . $url;
        $response = $this->guzzle->request($method, $uri);
        return $response;
    }
}
