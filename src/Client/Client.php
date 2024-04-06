<?php

namespace Sklemin\Client;

use Sklemin\Client\Exceptions\LoaderException;
use Sklemin\Client\Interfaces\LoaderInterface;
use Sklemin\Client\Interfaces\ResponseInterface;
use Sklemin\Client\Interfaces\UrlBuilderInterface;

class Client
{
    private LoaderInterface $loader;
    private UrlBuilderInterface $urlBuilder;

    public function __construct(LoaderInterface $loader, UrlBuilderInterface $urlBuilder)
    {
        $this->loader = $loader;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param array $headers
     * @return ResponseInterface
     * @throws LoaderException
     */
    public function getComments(array $headers = []): ResponseInterface
    {
        return $this->loader->load(
            $this->urlBuilder->getWithRoute('comments'),
            'GET',
            '',
            $headers
        );
    }

    /**
     * @param string $jsonEncodedBody
     * @param array $headers
     * @return ResponseInterface
     * @throws LoaderException
     */
    public function createComment(string $jsonEncodedBody, array $headers = []): ResponseInterface
    {
        return $this->loader->load(
            $this->urlBuilder->getWithRoute('comments'),
            'POST',
            $jsonEncodedBody,
            $headers
        );
    }

    /**
     * @param int $id
     * @param string $jsonEncodedBody
     * @param array $headers
     * @return ResponseInterface
     * @throws LoaderException
     */
    public function updateCommentById(int $id, string $jsonEncodedBody, array $headers = []): ResponseInterface
    {
        return $this->loader->load(
            $this->urlBuilder->getWithRouteAndArgs('comments', $id),
            'PUT',
            $jsonEncodedBody,
            $headers
        );
    }
}