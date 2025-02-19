<?php

namespace Anik\Paperfly\Transfers;

use Anik\Paperfly\Contracts\Transferable;

class CancelOrder implements Transferable
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
        return 'api/v1/cancel-order/';
    }

    public function requestBody(): array
    {
        return [
            'order_id' => $this->orderId,
        ];
    }
}
