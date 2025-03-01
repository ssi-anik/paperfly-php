<?php

namespace Anik\Paperfly\Transfers;

use Anik\Paperfly\Contracts\ExtendsResponse;
use Anik\Paperfly\Contracts\Transferable;
use Anik\Paperfly\Response;
use Anik\Paperfly\TrackOrderResponse;

class TrackOrder implements Transferable, ExtendsResponse
{
    private string $orderId;

    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
    }

    public static function orderId(string $orderId): self
    {
        return new self($orderId);
    }

    public function method(): string
    {
        return 'POST';
    }

    public function endpoint(): string
    {
        return '/API-Order-Tracking';
    }

    public function requestBody(): array
    {
        return [
            'ReferenceNumber' => $this->orderId,
        ];
    }

    public function getResponse(int $statusCode, string $content): Response
    {
        return new TrackOrderResponse($statusCode, $content);
    }
}
