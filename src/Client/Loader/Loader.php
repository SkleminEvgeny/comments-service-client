<?php

namespace Sklemin\Client\Loader;

use Sklemin\Client\Exceptions\LoaderException;
use Sklemin\Client\Interfaces\LoaderInterface;
use Sklemin\Client\Interfaces\ResponseInterface;
use Sklemin\Client\Response\Response;

class Loader implements LoaderInterface
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
    public function load(string $url, string $method = 'GET', string $body = '', array $headers = [], int $timeout = 30, array $options = []): ResponseInterface
    {
        // checking if cURL enabled
        if (!function_exists('curl_init')) {
            throw LoaderException::getException("cURL is not enabled");
        }

        $curl = \curl_init();

        $globalOptions = [
            CURLOPT_URL            => $url,
            CURLOPT_HEADER         => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ];

        switch ($method){
            case 'POST':
                $globalOptions += [
                    CURLOPT_POST       => true,
                    CURLOPT_POSTFIELDS => $body
                ];
                break;
            case 'PUT':
                $globalOptions += [
                    CURLOPT_CUSTOMREQUEST => 'PUT',
                    CURLOPT_POSTFIELDS    => $body
                ];
                break;
        }

        foreach ($options as $key => $value) {
            $globalOptions[$key] = $value;
        }

        \curl_setopt_array($curl, $globalOptions);

        $content = \curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = \curl_error($curl);

        \curl_close($curl);

        if ($err !== '') {
            throw LoaderException::getException($err);
        }

        return new Response($responseCode, $content);
    }
}