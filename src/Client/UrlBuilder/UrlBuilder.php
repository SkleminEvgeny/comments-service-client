<?php

namespace Sklemin\Client\UrlBuilder;

use Sklemin\Client\Interfaces\UrlBuilderInterface;

class UrlBuilder implements UrlBuilderInterface
{
    private string $scheme;
    private string $host;

    public function __construct(string $scheme, string $host)
    {
        $this->scheme = $scheme;
        $this->host   = $host;
    }

    public function getBaseUrl(): string
    {
        return sprintf('%s://%s', $this->scheme, $this->host);
    }

    public function getWithRoute(string $route): string
    {
        return sprintf('%s/%s/', $this->getBaseUrl(), $route);
    }

    public function getWithRouteAndArgs(string $route, string $argument): string
    {
        return sprintf('%s/%s/%s', $this->getBaseUrl(), $route, $argument);
    }
}