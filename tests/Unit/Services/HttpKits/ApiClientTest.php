<?php

namespace Tests\Unit\Services\HttpKits;

use App\Services\HttpKits\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class ApiClientTest extends TestCase
{
    public function testSendGetRequest()
    {
        $apiClient = new ApiClient();

        // fake
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['status' => true])),
            new Response(400, ['Content-Type' => 'application/json'], json_encode(['status' => false])),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $apiClient->setClient($client);

        $response = $apiClient->get('https://test.com');
        $this->assertTrue($response->isSuccessful());

        $response = $apiClient->get('https://test.com/?fail=true');
        $this->assertFalse($response->isSuccessful());
    }

    public function testSendPostRequest()
    {
        $apiClient = new ApiClient();

        // fake
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['created' => true])),
            new Response(201, ['Content-Type' => 'application/json'], json_encode(['created' => true])),
            new Response(201, ['Content-Type' => 'application/json'], json_encode(['created' => true])),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $apiClient->setClient($client);

        $response = $apiClient->setContentType(ApiClient::CONTENT_TYPE_FORM_DATA)
            ->post('https://test.com', ['ok' => true]);
        $this->assertTrue($response->isSuccessful());

        $response = $apiClient->setContentType(ApiClient::CONTENT_TYPE_FORM_ENCODED)
            ->post('https://test.com/submit', ['ok' => true]);
        $this->assertTrue($response->isSuccessful());

        $response = $apiClient->setContentType(ApiClient::CONTENT_TYPE_JSON)
            ->post('https://test.com/submit', ['ok' => true]);
        $this->assertTrue($response->isSuccessful());
    }

    public function testSendDeleteRequest()
    {
        $apiClient = new ApiClient();

        // fake
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['deleted' => true])),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $apiClient->setClient($client);

        $response = $apiClient->setHeaders(['test' => true])->delete('https://test.com');
        $this->assertTrue($response->isSuccessful());
    }

    public function testSetBaseURLShouldPrependBaseURL()
    {
        $apiClient = new ApiClient();

        // fake
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['test' => true])),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $apiClient->setClient($client);
        $apiClient->setBaseUrl('https://sethphat.com');

        $response = $apiClient->get('v1/users');
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('https://sethphat.com/v1/users', $response->endpoint);
    }
}
