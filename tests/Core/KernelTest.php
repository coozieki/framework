<?php

namespace tests\Core;

use App\Contracts\Http\ControllerInvoker;
use App\Contracts\Http\Request;
use App\Contracts\Http\Response;
use App\Contracts\Routing\Router;
use App\Contracts\Routing\Route;
use App\Core\Kernel;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    /**
     * @covers \App\Core\Kernel::handle
     */
    public function testHandle(): void
    {
        $controller = '::controller::';
        $method = '::method::';

        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $route = $this->createMock(Route::class);
        $route->expects(self::once())
            ->method('getController')
            ->willReturn($controller);
        $route->expects(self::once())
            ->method('getControllerMethod')
            ->willReturn($method);

        $controllerInvoker = $this->createMock(ControllerInvoker::class);
        $controllerInvoker->expects(self::once())
            ->method('invoke')
            ->with($controller, $method)
            ->willReturn($response);

        $router = $this->createMock(Router::class);
        $router->expects(self::once())
            ->method('formRouteList');
        $router->expects(self::once())
            ->method('getRequestedRoute')
            ->with($request)
            ->willReturn($route);

        $kernel = new Kernel($router, $controllerInvoker);

        $this->assertEquals($response, $kernel->handle($request));
    }
}
