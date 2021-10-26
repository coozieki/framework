<?php

namespace tests\Http;

use App\Http\HtmlResponse;
use App\Http\ResponseFactory;
use PHPUnit\Framework\TestCase;

class ResponseFactoryTest extends TestCase
{
    /**
     * @covers \App\Http\ResponseFactory::html
     */
    public function testHtml(): void
    {
        $text = '::text::';
        $factory = new ResponseFactory();

        $this->assertEquals(new HtmlResponse($text), $factory->html($text));
    }
}
