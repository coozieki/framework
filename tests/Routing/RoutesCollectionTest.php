<?php

namespace tests\Support;

use App\Routing\Route;
use App\Routing\RoutesCollection;
use PHPUnit\Framework\TestCase;

class RoutesCollectionTest extends TestCase
{
    /**
     * @covers \App\Routing\RoutesCollection::findByUri
     */
    public function testFindByUriWhenFound(): void
    {
        $uri1 = '::uri_1::';
        $route1 = $this->createMock(Route::class);
        $route1->expects(self::once())
            ->method('getUri')
            ->willReturn($uri1);

        $route2 = $this->createMock(Route::class);
        $route2->expects(self::never())
            ->method('getUri');

        $collection = new RoutesCollection([$route1, $route2]);

        $this->assertEquals($route1, $collection->findByUri($uri1));
    }

    /**
     * @covers \App\Routing\RoutesCollection::findByUri
     */
    public function testFindByUriWhenNotFound(): void
    {
        $collection = new RoutesCollection([]);

        $this->assertNull($collection->findByUri('uri'));
    }
}
