<?php

namespace App\Services\HttpKits;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class ApiClient
{
    public const CONTENT_TYPE_FORM_ENCODED = 'application/x-www-form-urlencoded';
    public const CONTENT_TYPE_FORM_DATA = 'multipart/form-data';
    public const CONTENT_TYPE_JSON = 'json';

    private HttpClient $client;
    private ClientResponse $response;
    private string $baseUrl;
    private array $headers;
    private string $contentType;

    public function __construct()
    {
        $this->client = new HttpClient();
    }

    /**
     * Set the baseURL
     *
     * @param string $url
     *
     * @return ApiClient
     */
    public function setBaseUrl(string $url): self
    {
        $this->baseUrl = $url;

        return $this;
    }

    /**
     * Set the headers
     *
     * @param array $headers
     *
     * @return ApiClient
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set the content type
     *
     * @param string $contentType
     *
     * @return ApiClient
     */
    public function setContentType(string $contentType = 'json'): self
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Making a request
     *
     * @param string $method
     * @param string $url
     * @param array $payload
     *
     * @return ClientResponse
     */
    private function request(string $method, string $url, array $payload): ClientResponse
    {
        $this->response = new ClientResponse();
        $options = [
            'headers' => $this->headers,
        ];

        if ($method == 'GET') {
            $options['query'] = $payload;
        } else {
            switch ($this->contentType) {
                case self::CONTENT_TYPE_FORM_ENCODED:
                    $options['form_params'] = $payload;
                    break;

                case self::CONTENT_TYPE_FORM_DATA:
                    $options['multipart'] = collect($payload)->map(fn($value, $key) => [
                        'name' => $key,
                        'contents' => $value
                    ])->toArray();
                    break;

                case self::CONTENT_TYPE_JSON:
                default:
                    $options['json'] = $payload;
                    break;
            }
        }

        $this->response->endpoint = $url;
        $this->response->request = $payload;

        if (isset($this->baseUrl)) {
            $hasEndingSlash = substr($this->baseUrl, -1, 1) === '/';
            $url = $this->baseUrl . (!$hasEndingSlash ? '/' : '') . $url;
        }

        try {
            $data = $this->client->request($method, $url, $options)->getBody();
            $this->response->body = $data;
            $this->response->data = json_decode((string) $data, true);
        } catch (GuzzleException | ClientException $e) {
            $this->response->responseCode = $e->getCode();
            $this->response->responseMessage = $e->getMessage();
            $this->response->data = json_decode($e->getResponse()->getBody(), true) ?? [];
        } finally {
            return $this->response;
        }
    }

    public function get(string $url, array $payload = []): ClientResponse
    {
        return $this->request('GET', $url, $payload);
    }

    public function post(string $url, array $data): ClientResponse
    {
        return $this->request('POST', $url, $data);
    }

    public function delete(string $url): ClientResponse
    {
        return $this->request('DELETE', $url, []);
    }
}
