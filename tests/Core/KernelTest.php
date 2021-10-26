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
use App\Http\Response\NotFoundResponse;
use App\Http\Response\ServerErrorResponse;
use App\Routing\Exceptions\NotFoundException;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    /**
     * @covers \App\Core\Kernel::handle
     */
    public function testHandleWhenRouteNotFound(): void
    {
        $controller = '::controller::';

        $request = $this->createMock(Request::class);
        $response = $this->createMock(NotFoundResponse::class);

        $route = $this->createMock(Route::class);
        $route->expects(self::once())
            ->method('getController')
            ->willReturn($controller);

        $controllerFactory = $this->createMock(ControllerFactory::class);
        $controllerFactory->expects(self::once())
            ->method('create')
            ->willThrowException($this->createMock(NotFoundException::class));

        $router = $this->createMock(Router::class);
        $router->expects(self::once())
            ->method('formRouteList');
        $router->expects(self::once())
            ->method('getRequestedRoute')
            ->with($request)
            ->willReturn($route);

        $responseFactory = $this->createMock(ResponseFactory::class);
        $responseFactory->expects(self::once())
            ->method('notFound')
            ->willReturn($response);

        $kernel = new Kernel($router, $controllerFactory, $responseFactory);

        $this->assertEquals($response, $kernel->handle($request));
    }

    /**
     * @covers \App\Core\Kernel::handle
     */
    public function testHandleWhenRouteFound(): void
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

        $controllerInstance = $this->createMock(Controller::class);
        $controllerInstance->expects(self::once())
            ->method('call')
            ->with($method)
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

        $kernel = new Kernel($router, $controllerFactory, $this->createMock(ResponseFactory::class));

        $this->assertEquals($response, $kernel->handle($request));
    }

    /**
     * @covers \App\Core\Kernel::handle
     */
    public function testHandleWhenThrowsServerError(): void
    {
        $response = $this->createMock(ServerErrorResponse::class);

        $router = $this->createMock(Router::class);
        $router->expects(self::once())
            ->method('formRouteList')
            ->willThrowException(new \Exception());

        $responseFactory = $this->createMock(ResponseFactory::class);
        $responseFactory->expects(self::once())
            ->method('serverError')
            ->willReturn($response);

        $kernel = new Kernel($router, $this->createMock(ControllerFactory::class), $responseFactory);

        $this->assertEquals($response, $kernel->handle($this->createMock(Request::class)));
    }
}
