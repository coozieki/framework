<?php

namespace tests\Unit\Routing;

use Coozieki\Framework\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /**
     * @covers \Coozieki\Framework\Routing\Route::getName
     */
    public function testGetNameWhenItIsNotInitialized(): void
    {
        $route = new Route('', '', '', '');

        $this->assertNull($route->getName());
    }

    /**
     * @covers \Coozieki\Framework\Routing\Route::getHttpMethod
     */
    public function testGetHttpMethod(): void
    {
        $httpMethod = 'GET';
        $route = new Route('', '','', $httpMethod);

        $this->assertEquals($httpMethod, $route->getHttpMethod());
    }

    /**
     * @covers \Coozieki\Framework\Routing\Route::getController
     */
    public function testGetController(): void
    {
        $controller = 'Controller';
        $route = new Route('', $controller, '', '');

        $this->assertEquals($controller, $route->getController());
    }

    /**
     * @covers \Coozieki\Framework\Routing\Route::getControllerMethod
     */
    public function testGetControllerMethod(): void
    {
        $controllerMethod = 'Controller';
        $route = new Route('', '', $controllerMethod, '');

        $this->assertEquals($controllerMethod, $route->getControllerMethod());
    }

    /**
     * @covers \Coozieki\Framework\Routing\Route::getUri
     */
    public function testGetUri(): void
    {
        $uri = 'Controller';
        $route = new Route( $uri, '', '', '');

        $this->assertEquals($uri, $route->getUri());
    }

    /**
     * @covers \Coozieki\Framework\Routing\Route::get
     */
    public function testGet(): void
    {
        $controller = 'Controller';
        $controllerMethod = 'Controller method';
        $uri = 'Uri';
        $expectedRoute = new Route($uri, $controller, $controllerMethod, 'GET');

        $route = Route::get($uri, [$controller, $controllerMethod]);

        $this->assertEquals($expectedRoute, $route);
    }

    /**
     * @covers \Coozieki\Framework\Routing\Route::name
     * @covers \Coozieki\Framework\Routing\Route::getName
     */
    public function testName(): void
    {
        $name = '::name::';
        $route = new Route('', '', '', '');

        $routeAfterMethod = $route->name($name);

        $this->assertSame($route, $routeAfterMethod);
        $this->assertEquals($name, $route->getName());
    }
}