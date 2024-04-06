<?php

namespace Sklemin\Client\Response;

use Sklemin\Client\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    /**
     * @var string
     */
    private string $headers;

    /**
     * @var string
     */
    private string $body;

    /**
     * @var string
     */
    private string $responseCode;

    public function __construct(string $responseCode, string $content)
    {
        $result             = $this->parseContent($content);
        $this->headers      = $result[0];
        $this->body         = $result[1];
        $this->responseCode = $responseCode;
    }

    /**
     * @return string
     */
    public function getHeaders(): string
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getResponseCode(): string
    {
        return $this->responseCode;
    }

    /**
     * @param string $content
     * @return array
     */
    private function parseContent(string $content): array
    {
        return preg_split('~\R{2}~', $content);
    }
}