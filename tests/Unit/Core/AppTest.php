<?php

namespace tests\Unit\Core;

require_once __DIR__ . '/../TestClasses/TemplatorExample.php';

use Coozieki\Contracts\View\Templator;
use Coozieki\Core\App;
use Coozieki\Contracts\Container\Container;
use Coozieki\Exceptions\ConfigurationException;
use Exception;
use PHPUnit\Framework\TestCase;
use tests\Unit\TestClasses\TemplatorExample;

class AppTest extends TestCase
{
    /**
     * @covers \Coozieki\Core\App::make
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
     * @covers \Coozieki\Core\App::bind
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
     * @covers \Coozieki\Core\App::singleton
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

    /**
     * @covers \Coozieki\Core\App::setTemplatorClass
     * @throws ConfigurationException
     */
    public function testSetTemplatorClassIfInstanceOfTemplator(): void
    {
        $templator = TemplatorExample::class;

        $container = $this->createMock(Container::class);
        $container->expects(self::once())
            ->method('register')
            ->with(Templator::class, $templator);

        $app = new App($container);

        $app->setTemplatorClass($templator);
    }

    /**
     * @covers \Coozieki\Core\App::setTemplatorClass
     * @throws ConfigurationException
     */
    public function testSetTemplatorClassIfNotInstanceOfTemplator(): void
    {
        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage('Custom Templator class must be instance of ' . Templator::class);

        $app = new App($this->createMock(Container::class));

        $app->setTemplatorClass(Exception::class);
    }
}
