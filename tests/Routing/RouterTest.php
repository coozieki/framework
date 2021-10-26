<?php

namespace tests\Routing;

use App\Contracts\Http\Request;
use App\Contracts\Routing\Route;
use App\Routing\Exceptions\NotFoundException;
use App\Routing\Router;
use App\Routing\RoutesCollection;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @covers \App\Routing\Router::getRequestedRoute
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
     * @covers \App\Routing\Router::getRequestedRoute
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
     * @covers \App\Routing\Router::formRouteList
     */
    public function testFormRouteList(): void
    {
        $collection = $this->createMock(RoutesCollection::class);
        $collection->expects(self::exactly(2))
            ->method('push');

        $router = new Router($collection);

        $router->formRouteList();
    }
}
