<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function request(string $method, string $uri, array $options = []): ResponseInterface;
}
