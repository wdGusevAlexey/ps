<?php

declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements HttpClientInterface
{
    public function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        $client = new Client([]);

        return $client->request($method, $uri, $options);
    }
}
