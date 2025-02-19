<?php

namespace Anik\Paperfly;

use stdClass;

class Response
{
    private int $code;
    private string $content;
    private ?string $message;

    public function __construct(int $code, string $content, ?string $message = null)
    {
        $this->code = $code;
        $this->content = $content;
        $this->message = $message;
    }

    public function isSuccessful(): bool
    {
        if ($this->code >= 200 && $this->code < 300) {
            return true;
        }

        return false;
    }

    public function wasTransferred(): bool
    {
        return $this->code >= 200 && $this->code <= 599;
    }

    public function message(): ?string
    {
        return $this->message;
    }

    public function contentRaw(): string
    {
        return $this->content;
    }

    public function content(bool $assoc = true)
    {
        if (empty($this->content)) {
            return null;
        }

        $data = json_decode($this->contentRaw(), $assoc);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $assoc ? [] : new stdClass();
        }

        return $data;
    }
}
