<?php

namespace tests\Http;

use App\Exceptions\NotImplementedException;
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

    /**
     * @covers \App\Http\ResponseFactory::redirect
     */
    public function testRedirect(): void
    {
        $this->expectException(NotImplementedException::class);

        $factory = new ResponseFactory();

        $factory->redirect();
    }
}
