<?php

namespace tests\Unit\Routing;

use Coozieki\Framework\Contracts\Http\Request;
use Coozieki\Framework\Contracts\Routing\Route;
use Coozieki\Framework\Routing\Exceptions\NotFoundException;
use Coozieki\Framework\Routing\Router;
use Coozieki\Framework\Routing\RoutesCollection;
use Coozieki\Framework\Support\File;
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

        $file = $this->createMock(File::class);

        $router = new Router($collection, $file);

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

        $file = $this->createMock(File::class);

        $router = new Router($collection, $file);

        $router->getRequestedRoute($request);
    }

    /**
     * @covers \Coozieki\Framework\Routing\Router::formRouteList
     */
    public function testFormRouteList(): void
    {
        $route1 = $this->createMock(Route::class);
        $route2 = $this->createMock(Route::class);

        $collection = $this->createMock(RoutesCollection::class);
        $collection->expects(self::exactly(2))
            ->method('push')
            ->withConsecutive([$route1], [$route2]);

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with(Router::DEFAULT_ROUTES_PATH)
            ->willReturn([$route1, $route2]);

        $router = new Router($collection, $file);

        $router->formRouteList();
    }

    /**
     * @covers \Coozieki\Framework\Routing\Router::formRouteList
     */
    public function testFormRouteListWithSettingRoutesPath(): void
    {
        $path = 'somepath/file.php';
        $route1 = $this->createMock(Route::class);
        $route2 = $this->createMock(Route::class);

        $collection = $this->createMock(RoutesCollection::class);
        $collection->expects(self::exactly(2))
            ->method('push')
            ->withConsecutive([$route1], [$route2]);

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with($path)
            ->willReturn([$route1, $route2]);

        $router = new Router($collection, $file);

        $router->setRoutesPath($path);

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

        $file = $this->createMock(File::class);

        $router = new Router($collection, $file);

        $this->assertEquals($routes, $router->getRoutes());
    }

    /**
     * @covers \Coozieki\Framework\Routing\Router::setRoutesPath
     * @covers \Coozieki\Framework\Routing\Router::getRoutesPath
     */
    public function testSetGetRoutesPath(): void
    {
        $path = 'routes2/web.php';
        $collection = $this->createMock(RoutesCollection::class);
        $file = $this->createMock(File::class);

        $router = new Router($collection, $file);

        $router->setRoutesPath($path);
        $this->assertEquals($path, $router->getRoutesPath());
    }

    /**
     * @covers \Coozieki\Framework\Routing\Router::configure
     */
    public function testConfigureWhenRoutesPathConfigured(): void
    {
        $path = 'path/to/routes';
        $configs = ['routesPath' => $path];
        $collection = $this->createMock(RoutesCollection::class);
        $file = $this->createMock(File::class);

        $router = new Router($collection, $file);

        $router->configure($configs);

        $this->assertEquals($path, $router->getRoutesPath());
    }

    /**
     * @covers \Coozieki\Framework\Routing\Router::configure
     */
    public function testConfigureWhenEmptyConfig(): void
    {
        $configs = [];
        $collection = $this->createMock(RoutesCollection::class);
        $file = $this->createMock(File::class);

        $router = new Router($collection, $file);

        $router->configure($configs);

        $this->assertEquals(Router::DEFAULT_ROUTES_PATH, $router->getRoutesPath());
    }
}
