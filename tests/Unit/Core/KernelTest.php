<?php

namespace tests\Unit\Core;

use Coozieki\Contracts\Http\Controller;
use Coozieki\Contracts\Http\ControllerFactory;
use Coozieki\Contracts\Http\Request;
use Coozieki\Contracts\Http\Response;
use Coozieki\Contracts\Http\ResponseFactory;
use Coozieki\Contracts\Routing\Router;
use Coozieki\Contracts\Routing\Route;
use Coozieki\Core\CoreConfiguration;
use Coozieki\Core\Kernel;
use Coozieki\Http\Response\NotFoundResponse;
use Coozieki\Http\Response\ServerErrorResponse;
use Coozieki\Routing\Exceptions\NotFoundException;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    /**
     * @covers \Coozieki\Core\Kernel::handle
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

        $configuration = $this->createMock(CoreConfiguration::class);
        $configuration->expects(self::once())
            ->method('setUp');

        $kernel = new Kernel($router, $controllerFactory, $responseFactory, $configuration);

        $this->assertEquals($response, $kernel->handle($request));
    }

    /**
     * @covers \Coozieki\Core\Kernel::handle
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

        $configuration = $this->createMock(CoreConfiguration::class);
        $configuration->expects(self::once())
            ->method('setUp');

        $kernel = new Kernel($router, $controllerFactory, $this->createMock(ResponseFactory::class), $configuration);

        $this->assertEquals($response, $kernel->handle($request));
    }

    /**
     * @covers \Coozieki\Core\Kernel::handle
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

        $configuration = $this->createMock(CoreConfiguration::class);
        $configuration->expects(self::once())
            ->method('setUp');

        $kernel = new Kernel($router, $this->createMock(ControllerFactory::class), $responseFactory, $configuration);

        $this->assertEquals($response, $kernel->handle($this->createMock(Request::class)));
    }
}
