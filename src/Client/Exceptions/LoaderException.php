<?php

namespace Sklemin\Client\Exceptions;

use Sklemin\Client\Interfaces\ExceptionInterface;

class LoaderException extends \Exception implements ExceptionInterface
{
    public static function getException($message = ''): LoaderException
    {
        return new self(sprintf('Request was failed. Message: %s', $message));
    }
}