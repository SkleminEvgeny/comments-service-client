<?php

namespace Sklemin\Client\Interfaces;

use Sklemin\Client\Exceptions\LoaderException;

interface LoaderInterface
{
    /**
     * @param string $url
     * @param string $method
     * @param string $body
     * @param array $headers
     * @param int $timeout
     * @param array $options
     * @return ResponseInterface
     * @throws LoaderException
     */
    public function load(string $url, string $method, string $body, array $headers, int $timeout, array $options): ResponseInterface;
}