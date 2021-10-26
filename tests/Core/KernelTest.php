<?php

namespace tests\Core;

use App\Contracts\Http\Controller;
use App\Contracts\Http\ControllerFactory;
use App\Contracts\Http\Request;
use App\Contracts\Http\Response;
use App\Contracts\Http\ResponseFactory;
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

        $responseFactory = $this->createMock(ResponseFactory::class);

        $controllerInstance = $this->createMock(Controller::class);
        $controllerInstance->expects(self::once())
            ->method('call')
            ->with($responseFactory, $method)
            ->willReturn($response);

        $controllerFactory = $this->createMock(ControllerFactory::class);
        $controllerFactory->expects(self::once())
            ->method('create')
            ->with($controller)
            ->willReturn($controllerInstance);

        $router = $this->createMock(Router::class);
        $router->expects(self::once())
            ->method('formRouteList');
        $router->expects(self::once())
            ->method('getRequestedRoute')
            ->with($request)
            ->willReturn($route);

        $kernel = new Kernel($router, $controllerFactory, $responseFactory);

        $this->assertEquals($response, $kernel->handle($request));
    }
}
