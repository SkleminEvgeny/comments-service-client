<?php

namespace Sklemin\Client\Interfaces;

interface ResponseInterface
{
    public function getHeaders(): string;

    public function getBody(): string;

    public function getResponseCode(): string;
}