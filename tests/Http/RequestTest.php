<?php

namespace tests\Http;

use App\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @covers \App\Http\Request::getMethod
     */
    public function testGetMethod(): void
    {
        $method = '::method::';
        $_SERVER['REQUEST_METHOD'] = $method;

        $request = new Request();

        $this->assertEquals($method, $request->getMethod());
    }

    /**
     * @covers \App\Http\Request::getRequestedUri
     */
    public function testGetRequestedUri(): void
    {
        $uri = '::uri::';
        $_SERVER['REQUEST_URI'] = $uri;

        $request = new Request();

        $this->assertEquals($uri, $request->getRequestedUri());
    }
}
