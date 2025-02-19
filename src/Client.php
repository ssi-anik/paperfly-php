<?php

namespace Anik\Paperfly;

use Anik\Paperfly\Contracts\Transferable;
use Composer\InstalledVersions;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Throwable;

class Client
{
    protected GuzzleClient $client;

    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    public static function useDefaultGuzzleClient(
        string $username,
        string $password,
        string $requiredHeaderValue,
        string $requiredHeaderName = 'paperflykey',
        string $baseUrl = 'https://api.paperfly.com.bd'
    ): Client {
        try {
            $version = InstalledVersions::getPrettyVersion('anik/paperfly');
        } catch (Throwable $t) {
            $version = '0.0.0';
        }

        $client = new GuzzleClient([
            'base_uri' => $baseUrl,
            'auth' => [
                $username,
                $password,
            ],
            RequestOptions::HEADERS => [
                'user-agent' => sprintf('anik/paperfly@php-%s', $version),
                $requiredHeaderName => $requiredHeaderValue,
            ],
        ]);

        return new static($client);
    }

    public function transfer(Transferable $transferable): array
    {
        if (strtoupper($method = $transferable->method()) == 'GET') {
            $optionKey = RequestOptions::QUERY;
        } else {
            $optionKey = RequestOptions::JSON;
        }

        $response = $this->client->request(
            $method,
            $transferable->endpoint(),
            [
                $optionKey => $transferable->requestBody(),
            ]
        );

        return [
            'error' => false,
            'status' => $response->getStatusCode(),
            'content' => $response->getBody()->getContents(),
        ];
    }

    public function gracefulTransfer(Transferable $transferable): array
    {
        try {
            return $this->transfer($transferable);
        } catch (Throwable $t) {
            return [
                'error' => true,
                'code' => $t->getCode(),
                'message' => $t->getMessage(),
                'content' => $t instanceof RequestException ? $t->getResponse()->getBody()->getContents() : '{}',
            ];
        }
    }
}
