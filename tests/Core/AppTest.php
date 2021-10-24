<?php

namespace tests\Core;

use App\Core\App;
use App\Contracts\Container\Container;
use Exception;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    /**
     * @covers \App\Core\App::make
     */
    public function testMake(): void
    {
        $class = Exception::class;
        $binding = new Exception('::message::');

        $container = $this->createMock(Container::class);
        $container->expects(self::once())
            ->method('resolve')
            ->with($class)
            ->willReturn($binding);

        $app = new App($container);

        $this->assertSame($binding, $app->make($class));
    }

    /**
     * @covers \App\Core\App::bind
     */
    public function testBind(): void
    {
        $class = Exception::class;
        $binding = new Exception('::message::');

        $container = $this->createMock(Container::class);
        $container->expects(self::once())
            ->method('register')
            ->with($class, $binding);

        $app = new App($container);

        $app->bind($class, $binding);
    }

    /**
     * @covers \App\Core\App::singleton
     */
    public function testSingleton(): void
    {
        $class = Exception::class;
        $binding = new Exception('::message::');

        $container = $this->createMock(Container::class);
        $container->expects(self::once())
            ->method('singleton')
            ->with($class, $binding);

        $app = new App($container);

        $app->singleton($class, $binding);
    }
}
