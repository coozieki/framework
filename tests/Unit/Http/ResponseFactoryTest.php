<?php

namespace tests\Unit\Http;

use Coozieki\Exceptions\NotImplementedException;
use Coozieki\Http\Response\HtmlResponse;
use Coozieki\Http\Response\NotFoundResponse;
use Coozieki\Http\Response\ServerErrorResponse;
use Coozieki\Http\ResponseFactory;
use PHPUnit\Framework\TestCase;

class ResponseFactoryTest extends TestCase
{
    /**
     * @covers \Coozieki\Http\ResponseFactory::html
     */
    public function testHtml(): void
    {
        $text = '::text::';
        $factory = new ResponseFactory();

        $this->assertEquals(new HtmlResponse($text), $factory->html($text));
    }

    /**
     * @covers \Coozieki\Http\ResponseFactory::redirect
     */
    public function testRedirect(): void
    {
        $this->expectException(NotImplementedException::class);

        $factory = new ResponseFactory();

        $factory->redirect();
    }

    /**
     * @covers \Coozieki\Http\ResponseFactory::notFound
     */
    public function testNotFound(): void
    {
        $factory = new ResponseFactory();

        $this->assertEquals(new NotFoundResponse(), $factory->notFound());
    }

    /**
     * @covers \Coozieki\Http\ResponseFactory::serverError
     */
    public function testServerError(): void
    {
        $factory = new ResponseFactory();

        $this->assertEquals(new ServerErrorResponse(), $factory->serverError());
    }
}
