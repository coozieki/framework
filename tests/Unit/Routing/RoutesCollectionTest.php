<?php

namespace tests\Unit\Routing;

use Coozieki\Contracts\Http\Request;
use Coozieki\Contracts\Routing\Route;
use Coozieki\Routing\RoutesCollection;
use PHPUnit\Framework\TestCase;

class RoutesCollectionTest extends TestCase
{
    /**
     * @covers \Coozieki\Routing\RoutesCollection::findRequestedRoute
     */
    public function testFindRequestedRouteWhenFound(): void
    {
        $uri1 = '::uri_1::';
        $httpMethod1 = '::method_1::';

        $route1 = $this->createMock(Route::class);
        $route1->expects(self::once())
            ->method('getUri')
            ->willReturn($uri1);
        $route1->expects(self::once())
            ->method('getHttpMethod')
            ->willReturn($httpMethod1);

        $route2 = $this->createMock(Route::class);
        $route2->expects(self::never())
            ->method('getUri');

        $request = $this->createMock(Request::class);
        $request->expects(self::once())
            ->method('getMethod')
            ->willReturn($httpMethod1);
        $request->expects(self::once())
            ->method('getRequestedUri')
            ->willReturn($uri1);

        $collection = new RoutesCollection([$route1, $route2]);

        $this->assertEquals($route1, $collection->findRequestedRoute($request));
    }

    /**
     * @covers \Coozieki\Routing\RoutesCollection::findRequestedRoute
     */
    public function testFindRequestedRouteWhenNotFound(): void
    {
        $collection = new RoutesCollection([]);

        $this->assertNull($collection->findRequestedRoute($this->createMock(Request::class)));
    }
}
