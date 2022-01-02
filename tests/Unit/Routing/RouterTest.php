<?php

namespace tests\Unit\Routing;

use Coozieki\Framework\Contracts\Http\Request;
use Coozieki\Framework\Contracts\Routing\Route;
use Coozieki\Framework\Exceptions\FileNotFoundException;
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
     * @throws FileNotFoundException
     */
    public function testFormRouteList(): void
    {
        $path = './'.Router::DEFAULT_ROUTES_PATH;

        $route1 = $this->createMock(Route::class);
        $route2 = $this->createMock(Route::class);

        $collection = $this->createMock(RoutesCollection::class);
        $collection->expects(self::exactly(2))
            ->method('push')
            ->withConsecutive([$route1], [$route2]);

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('formatPath')
            ->with($path)
            ->willReturn($path);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with($path)
            ->willReturn([$route1, $route2]);

        $router = new Router($collection, $file);

        $router->formRouteList();
    }

    /**
     * @covers \Coozieki\Framework\Routing\Router::formRouteList
     * @throws FileNotFoundException
     */
    public function testFormRouteListWithSettingRoutesPath(): void
    {
        $config = [
            'routesPath' => 'somepath/file.php',
            'basePath' => 'basepath'
        ];
        $path = $config['basePath'].'/'.$config['routesPath'];
        $route1 = $this->createMock(Route::class);
        $route2 = $this->createMock(Route::class);

        $collection = $this->createMock(RoutesCollection::class);
        $collection->expects(self::exactly(2))
            ->method('push')
            ->withConsecutive([$route1], [$route2]);

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('formatPath')
            ->with($path)
            ->willReturn($path);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with($path)
            ->willReturn([$route1, $route2]);

        $router = new Router($collection, $file);

        $router->configure($config);

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
}
