<?php

namespace Anik\Paperfly\Contracts;

interface Transferable
{
    public function method(): string;

    public function endpoint(): string;

    public function requestBody(): array;
}
