<?php

namespace Tests;

use App\Services\HttpKits\ClientResponse;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker, DatabaseTransactions;

    /**
     * Get Successful Mocked External Service Response
     *
     * @param string $path
     *
     * @return ClientResponse
     */
    protected function getSuccessfulMockedResponse(string $path): ClientResponse
    {
        $clientResponse = new ClientResponse();
        $clientResponse->responseSuccess = true;
        $clientResponse->data = $this->getMockedResponse($path);

        return $clientResponse;
    }

    /**
     * Get Error Mocked External Service Response
     *
     * @param string|null $path
     *
     * @return ClientResponse
     */
    protected function getErrorMockedResponse(string $path = null): ClientResponse
    {
        $clientResponse = new ClientResponse();
        $clientResponse->responseSuccess = false;
        $clientResponse->data = $path ? $this->getMockedResponse($path) : [];

        return $clientResponse;
    }


    /**
     * Get Mocked External Service Response
     *
     * @param string $path
     *
     * @return array|null
     */
    protected function getMockedResponse(string $path): ?array
    {
        return json_decode(file_get_contents($path), true);
    }
}
