<?php

namespace Anik\Paperfly;

use Anik\Paperfly\Contracts\Transferable;

class TrackOrder implements Transferable
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
}
