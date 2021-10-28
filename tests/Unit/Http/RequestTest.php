<?php

namespace tests\Unit\Http;

use Coozieki\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @covers \Coozieki\Http\Request::getMethod
     */
    public function testGetMethod(): void
    {
        $method = '::method::';
        $_SERVER['REQUEST_METHOD'] = $method;

        $request = new Request();

        $this->assertEquals($method, $request->getMethod());
    }

    /**
     * @covers \Coozieki\Http\Request::getRequestedUri
     */
    public function testGetRequestedUri(): void
    {
        $uri = '::uri::';
        $_SERVER['REQUEST_URI'] = $uri;

        $request = new Request();

        $this->assertEquals($uri, $request->getRequestedUri());
    }
}
