<?php

namespace tests\Http;

require_once __DIR__ . "/../TestClasses/ControllerExample.php";

use App\Contracts\Http\Response;
use App\Core\App;
use App\Http\ControllerInvoker;
use PHPUnit\Framework\TestCase;
use tests\TestClasses\ControllerExample;

class ControllerInvokerTest extends TestCase
{
    /**
     * @covers \App\Http\ControllerInvoker::invoke
     */
    public function testInvoke(): void
    {
        $controller = ControllerExample::class;
        $method = 'index';
        $response = $this->createMock(Response::class);

        $controllerInstance = $this->createMock($controller);
        $controllerInstance->expects(self::once())
            ->method($method)
            ->willReturn($response);

        $app = $this->createMock(App::class);
        $app->expects(self::once())
            ->method('make')
            ->with($controller)
            ->willReturn($controllerInstance);

        $invoker = new ControllerInvoker($app);

        $this->assertEquals($response, $invoker->invoke($controller, $method));
    }
}
