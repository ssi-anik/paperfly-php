<?php

namespace Anik\Paperfly;

class CreateOrderResponse extends Response
{
    protected array $parsed;

    protected function parseResponseIfNotParsed(): void
    {
        if (!isset($this->parsed)) {
            $this->parsed = $this->content();
        }
    }

    public function trackingNumber(): ?string
    {
        $this->parseResponseIfNotParsed();

        return $this->parsed['success']['tracking_number'] ?? null;
    }

    public function trackingBarcode(): ?string
    {
        $this->parseResponseIfNotParsed();

        return $this->parsed['success']['tracking_barcode'] ?? null;
    }
}
