<?php

namespace Sklemin\Tests\Functional\Client;

use PHPUnit\Framework\TestCase;
use Sklemin\Client\Client;
use Sklemin\Client\ClientBuilder\ClientBuilder;
use Sklemin\Client\Exceptions\LoaderException;

class ClientTest extends TestCase
{
    private Client $object;

    public function setUp(): void
    {
        $this->object = ClientBuilder::build('https', 'jsonplaceholder.typicode.com');
        $this->object2 = ClientBuilder::build('https', 'some.incorrect.host===');
    }

    public function testGetCommentsFromJsonPlaceholder()
    {
        $result = $this->object->getComments()->getBody();

        $this->assertNotEmpty($result);
        $this->assertJson($result);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/data/jsonplaceholderGetCommentsResult.json', $result);
    }

    public function testGetCommentsWithIncorrectHeadersFromJsonPlaceholder()
    {
        $result = $this->object->getComments([6, null, 566565, "test string"])->getBody();

        $this->assertNotEmpty($result);
        $this->assertJson($result);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/data/jsonplaceholderGetCommentsResult.json', $result);
    }

    public function testCreateNewCommentOnJsonPlaceholder()
    {
        $body = \json_encode([
            'body'   => 'Some comment body',
            'title'  => 'some comment title'
        ]);
        $result = $this->object->createComment($body, ['Content-type: application/json'])->getBody();
        $this->assertNotEmpty($result);
        $this->assertJson($result);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/data/jsonplaceholderCreateCommentResponse.json', $result);
    }

    public function testCreateWithEmptyBodyOnJsonPlaceholder()
    {
        $body = '';
        $result = $this->object->createComment($body, ['Content-type: application/json'])->getBody();

        $this->assertNotEmpty($result);
        $this->assertJson($result);
        $this->assertJsonStringNotEqualsJsonFile(__DIR__ . '/data/jsonplaceholderCreateCommentResponse.json', $result);
    }

    public function testCreateWithEmptyHeadersOnJsonPlaceholder()
    {
        $body = \json_encode([
            'body'   => 'Some comment body',
            'title'  => 'some comment title'
        ]);
        $result = $this->object->createComment($body)->getBody();

        $this->assertNotEmpty($result);
        $this->assertJson($result);
        $this->assertJsonStringNotEqualsJsonFile(__DIR__ . '/data/jsonplaceholderCreateCommentResponse.json', $result);
    }

    public function testUpdateCommentByIdOnJsonPlaceholder()
    {
        $body = \json_encode([
            'body'   => 'Some comment body changed',
            'title'  => 'some comment title changed'
        ]);
        $result = $this->object->updateCommentById(1, $body, ['Content-type: application/json'])->getBody();

        $this->assertNotEmpty($result);
        $this->assertJson($result);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/data/jsonplaceholderUpdateCommentByIdResponse.json', $result);
    }

    public function testUpdateCommentByIdWithEmptyBodyOnJsonPlaceholder()
    {
        $body = '';
        $result = $this->object->updateCommentById(1, $body, ['Content-type: application/json'])->getBody();

        $this->assertNotEmpty($result);
        $this->assertJson($result);
        $this->assertJsonStringNotEqualsJsonFile(__DIR__ . '/data/jsonplaceholderUpdateCommentByIdResponse.json', $result);
    }

    public function testUpdateCommentByIdWithEmptyHeadersOnJsonPlaceholder()
    {
        $body = \json_encode([
            'body'   => 'Some comment body changed',
            'title'  => 'some comment title changed'
        ]);
        $result = $this->object->updateCommentById(1, $body)->getBody();

        $this->assertNotEmpty($result);
        $this->assertJson($result);
        $this->assertJsonStringNotEqualsJsonFile(__DIR__ . '/data/jsonplaceholderUpdateCommentByIdResponse.json', $result);
    }

    public function testUpdateCommentByIdWithNotExistedIdOnJsonPlaceholder()
    {
        $body = \json_encode([
            'body'   => 'Some comment body changed',
            'title'  => 'some comment title changed'
        ]);
        $result = $this->object->updateCommentById(1000000000000, $body, ['Content-type: application/json'])->getBody();

        $this->assertNotEmpty($result);
        $this->assertStringContainsString('TypeError: Cannot read properties of undefined', $result);
    }

    public function testUpdateCommentByIdWithEmptyBodyAndHeadersOnJsonPlaceholder()
    {
        $body = '';
        $result = $this->object->updateCommentById(44, $body)->getBody();

        $this->assertNotEmpty($result);
        $this->assertJson($result);
        $this->assertStringContainsString('"id": 44', $result);
    }

    public function testIncorrectConfigurationBuiltObject()
    {
        $this->expectException(LoaderException::class);
        $this->object2->getComments();
    }
}