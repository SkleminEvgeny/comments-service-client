<?php

namespace Sklemin\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sklemin\Client\Client;
use Sklemin\Client\Interfaces\LoaderInterface;
use Sklemin\Client\Interfaces\ResponseInterface;
use Sklemin\Client\Interfaces\UrlBuilderInterface;

class ClientTest extends TestCase
{
    private Client $object;

    public function setUp(): void
    {
        $this->object = new Client(new LoaderMock(), new UrlBuilderMock());
    }

    public function testGetCommentsWithoutArg()
    {
        $this->assertNotEmpty($this->object->getComments()->getBody());
    }

    public function testGetCommentsWithIncorrectTypeArg()
    {
        $this->expectException(\TypeError::class);
        $this->object->getComments(1)->getBody();
    }

    public function testGetCommentsWithEmptyArrayArg()
    {
        $this->assertNotEmpty($this->object->getComments([])->getBody());
    }

    public function testCreateCommentWithoutArguments(): void
    {
        $this->expectException(\TypeError::class);
        $this->object->createComment()->getBody();
    }

    public function testCreateCommentWithEmptyStringBody(): void
    {
        $this->assertNotEmpty($this->object->createComment('')->getBody());
    }

    public function testUpdateCommentByIdWithoutArguments()
    {
        $this->expectException(\TypeError::class);
        $this->object->updateCommentById()->getBody();
    }

    public function testUpdateCommentByIdWithStringIntLikeIdArgument()
    {
        $result = $this->object->updateCommentById('33', '')->getBody();
        $this->assertNotEmpty($result);
    }

    public function testUpdateCommentByIdWithStringIdArgument()
    {
        $this->expectException(\TypeError::class);
        $this->object->updateCommentById('test', '');
    }
}

class LoaderMock implements LoaderInterface
{
    public function load(string $url, string $method = 'GET', string $body = '', array $headers = [], int $timeout = 30, array $options = []): ResponseInterface
    {
        return new MockResponse('200', '');
    }
}


class MockResponse implements ResponseInterface
{
    /**
     * @var string|mixed
     */
    private string $headers;
    /**
     * @var mixed
     */
    private $body;
    /**
     * @var string
     */
    private string $responseCode;

    public function __construct(string $responseCode, string $content)
    {
        $this->headers      = '';
        $this->body         = 'some body';
        $this->responseCode = '200';
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
}
class UrlBuilderMock implements UrlBuilderInterface
{
    public function getBaseUrl(): string
    {
        return '';
    }

    public function getWithRoute(string $route): string
    {
        return '';
    }

    public function getWithRouteAndArgs(string $route, string $argument): string
    {
        return '';
    }
}