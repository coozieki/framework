<?php

namespace Coozieki\Framework\Contracts\Http;

interface Request
{
    public function getMethod(): string;

    public function getRequestedUri(): string;
}
