<?php

namespace Core;

use GuzzleHttp\Client;

class BaseRequest
{
    public Client $client;

    function __construct(array $config = [])
    {
        $configs = [...$config, "verify" => false];
        $this->client = new Client($configs);
    }
}
