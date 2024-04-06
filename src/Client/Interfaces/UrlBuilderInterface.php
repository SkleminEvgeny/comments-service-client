<?php

namespace Sklemin\Client\Interfaces;

interface UrlBuilderInterface
{
    public function getBaseUrl(): string;

    public function getWithRoute(string $route): string;

    public function getWithRouteAndArgs(string $route, string $argument): string;
}