<?php

namespace tests\Unit\Routing;

use Coozieki\Framework\Contracts\Http\Request;
use Coozieki\Framework\Contracts\Routing\Route;
use Coozieki\Framework\Routing\Exceptions\NotFoundException;
use Coozieki\Framework\Routing\Router;
use Coozieki\Framework\Routing\RoutesCollection;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @covers \Coozieki\Framework\Routing\Router::getRequestedRoute
     * @throws NotFoundException
     */
    public function testGetRequestedRouteWhenFound(): void
    {
        $request = $this->createMock(Request::class);
        $route = $this->createMock(Route::class);

        $collection = $this->createMock(RoutesCollection::class);
        $collection->expects(self::once())
            ->method('findRequestedRoute')
            ->with($request)
            ->willReturn($route);

        $router = new Router($collection);

        $this->assertEquals($route, $router->getRequestedRoute($request));
    }

    /**
     * @covers \Coozieki\Framework\Routing\Router::getRequestedRoute
     */
    public function testGetRequestedRouteWhenNotFound(): void
    {
        $this->expectException(NotFoundException::class);

        $request = $this->createMock(Request::class);

        $collection = $this->createMock(RoutesCollection::class);
        $collection->expects(self::once())
            ->method('findRequestedRoute')
            ->with($request)
            ->willReturn(null);

        $router = new Router($collection);

        $router->getRequestedRoute($request);
    }

    /**
     * @covers \Coozieki\Framework\Routing\Router::formRouteList
     */
    public function testFormRouteList(): void
    {
        $collection = $this->createMock(RoutesCollection::class);
        $collection->expects(self::exactly(2))
            ->method('push');

        $router = new Router($collection);

        $router->formRouteList();
    }

    /**
     * @covers \Coozieki\Framework\Routing\Router::getRoutes
     */
    public function testGetRoutes(): void
    {
        $routes = [$this->createMock(Route::class), $this->createMock(Route::class)];

        $collection = $this->createMock(RoutesCollection::class);
        $collection->expects(self::once())
            ->method('all')
            ->willReturn($routes);

        $router = new Router($collection);

        $this->assertEquals($routes, $router->getRoutes());
    }
}
