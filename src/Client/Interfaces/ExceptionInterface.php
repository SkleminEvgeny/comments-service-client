<?php

namespace Sklemin\Client\Interfaces;

interface ExceptionInterface
{
    public static function getException($message = ''): \Exception;
}