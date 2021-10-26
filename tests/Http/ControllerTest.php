<?php

namespace tests\Http;

require_once __DIR__ . '/../TestClasses/ControllerExample.php';

use App\Contracts\Http\ResponseFactory;
use App\Exceptions\MethodNotFoundException;
use PHPUnit\Framework\TestCase;
use tests\TestClasses\ControllerExample;

class ControllerTest extends TestCase
{
    /**
     * @covers \App\Http\Controller::call
     *
     * @throws MethodNotFoundException
     */
    public function testCallWhenMethodDoesntExist(): void
    {
        $controller = ControllerExample::class;
        $method = '::method::';

        $this->expectException(MethodNotFoundException::class);
        $this->expectExceptionMessage(sprintf('Method "%s" not found in "%s"', $method, $controller));

        $responseFactory = $this->createMock(ResponseFactory::class);

        $instance = new $controller();
        $instance->call($responseFactory, $method);
    }

    /**
     * @covers \App\Http\Controller::call
     *
     * @throws MethodNotFoundException
     */
    public function testCallWhenMethodExists(): void
    {
        $method = 'index';

        $responseFactory = $this->createMock(ResponseFactory::class);

        $instance = new ControllerExample();

        $this->assertEquals($instance->index(), $instance->call($responseFactory, $method));
    }
}
