<?php

namespace Anik\Paperfly;

class TrackOrderResponse extends Response
{
    protected array $parsed;

    protected function parseResponseIfNotParsed(): void
    {
        if (!isset($this->parsed)) {
            $this->parsed = $this->content();
        }
    }

    public function currentStatus(): string
    {
        $this->parseResponseIfNotParsed();

        return orderStatus($this->parsed['success']['trackingStatus'][0]);
    }
}
