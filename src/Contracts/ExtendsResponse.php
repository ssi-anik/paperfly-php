<?php

namespace Anik\Paperfly\Contracts;

use Anik\Paperfly\Response;

interface ExtendsResponse
{
    public function getResponse(int $statusCode, string $content, ?string $message = null): Response;
}
