<?php

namespace Sklemin\Client\ClientBuilder;

use Sklemin\Client\Client;
use Sklemin\Client\Loader\Loader;
use Sklemin\Client\UrlBuilder\UrlBuilder;

class ClientBuilder
{
    public static function build($scheme = 'https', $host = 'localhost'): Client
    {
        return new Client(new Loader(), new UrlBuilder($scheme, $host));
    }
}