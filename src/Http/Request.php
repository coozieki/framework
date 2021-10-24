<?php

namespace App\Http;

use App\Contracts\Http\Request as RequestInterface;

class Request implements RequestInterface
{
    private array $server;

    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->server = $_SERVER;
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getRequestedUri(): string
    {
        return $this->server['REQUEST_URI'];
    }
}
