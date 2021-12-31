<?php

namespace tests\Unit\Core;

require_once __DIR__ . '/../TestClasses/TemplatorExample.php';

use Coozieki\Framework\Contracts\View\Templator;
use Coozieki\Framework\Core\App;
use Coozieki\Framework\Contracts\Container\Container;
use Coozieki\Framework\Exceptions\ConfigurationException;
use Exception;
use PHPUnit\Framework\TestCase;
use tests\Unit\TestClasses\TemplatorExample;

class AppTest extends TestCase
{
    /**
     * @covers \Coozieki\Framework\Core\App::make
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
     * @covers \Coozieki\Framework\Core\App::bind
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
     * @covers \Coozieki\Framework\Core\App::singleton
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
     * @covers \Coozieki\Framework\Core\App::setTemplatorClass
     * @throws ConfigurationException
     */
    public function testSetTemplatorClassIfInstanceOfTemplator(): void
    {
        $templator = TemplatorExample::class;
        $templatorInstance = $this->createMock($templator);

        $container = $this->createMock(Container::class);
        $container->expects(self::once())
            ->method('resolve')
            ->with($templator)
            ->willReturn($templatorInstance);
        $container->expects(self::once())
            ->method('singleton')
            ->with(Templator::class, $templatorInstance);

        $app = new App($container);

        $app->setTemplatorClass($templator);
    }

    /**
     * @covers \Coozieki\Framework\Core\App::setTemplatorClass
     * @throws ConfigurationException
     */
    public function testSetTemplatorClassIfNotInstanceOfTemplator(): void
    {
        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage('Custom Templator class must be instance of ' . Templator::class);

        $app = new App($this->createMock(Container::class));

        $app->setTemplatorClass(Exception::class);
    }

    /**
     * @covers App
     */
    public function testInstance(): void
    {
        $app = new App($this->createMock(Container::class));

        $this->assertSame(App::$instance, $app);
    }
}
