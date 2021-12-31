<?php

namespace tests\Unit\Http;

use Coozieki\Framework\Exceptions\NotImplementedException;
use Coozieki\Framework\Http\Response\HtmlResponse;
use Coozieki\Framework\Http\Response\JsonResponse;
use Coozieki\Framework\Http\Response\NotFoundResponse;
use Coozieki\Framework\Http\Response\RedirectResponse;
use Coozieki\Framework\Http\Response\ServerErrorResponse;
use Coozieki\Framework\Http\ResponseFactory;
use PHPUnit\Framework\TestCase;

class ResponseFactoryTest extends TestCase
{
    /**
     * @covers \Coozieki\Framework\Http\ResponseFactory::html
     */
    public function testHtml(): void
    {
        $text = '::text::';
        $factory = new ResponseFactory();

        $this->assertEquals(new HtmlResponse($text), $factory->html($text));
    }

    /**
     * @covers \Coozieki\Framework\Http\ResponseFactory::json
     */
    public function testJson(): void
    {
        $data = ['::some_data::'];
        $factory = new ResponseFactory();

        $this->assertEquals(new JsonResponse($data), $factory->json($data));
    }

    /**
     * @covers \Coozieki\Framework\Http\ResponseFactory::redirect
     */
    public function testRedirect(): void
    {
        $location = "http://example.com";
        $code = 302;
        $factory = new ResponseFactory();

        $this->assertEquals(new RedirectResponse($location, $code), $factory->redirect($location, $code));
    }

    /**
     * @covers \Coozieki\Framework\Http\ResponseFactory::notFound
     */
    public function testNotFound(): void
    {
        $factory = new ResponseFactory();

        $this->assertEquals(new NotFoundResponse(), $factory->notFound());
    }

    /**
     * @covers \Coozieki\Framework\Http\ResponseFactory::serverError
     */
    public function testServerError(): void
    {
        $factory = new ResponseFactory();

        $this->assertEquals(new ServerErrorResponse(), $factory->serverError());
    }
}
