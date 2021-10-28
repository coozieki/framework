<?php

namespace tests\Unit\Http;

require_once __DIR__ . '/../TestClasses/ControllerExample.php';

use Coozieki\Contracts\Http\ResponseFactory;
use Coozieki\Contracts\View\Templator;
use Coozieki\Exceptions\ConfigurationException;
use Coozieki\Exceptions\MethodNotFoundException;
use Coozieki\Http\Controller;
use PHPUnit\Framework\TestCase;
use tests\Unit\TestClasses\ControllerExample;

class ControllerTest extends TestCase
{
    /**
     * @covers \Coozieki\Http\Controller::call
     *
     * @throws MethodNotFoundException
     */
    public function testCallWhenMethodDoesntExist(): void
    {
        $controller = ControllerExample::class;
        $method = '::method::';

        $this->expectException(MethodNotFoundException::class);
        $this->expectExceptionMessage(sprintf('Method "%s" not found in "%s"', $method, $controller));

        $instance = new $controller();
        $instance->call($method);
    }

    /**
     * @covers \Coozieki\Http\Controller::call
     * @covers \Coozieki\Http\Controller::render
     * @covers \Coozieki\Http\Controller::setTemplator
     * @covers \Coozieki\Http\Controller::setResponseFactory
     *
     * @throws MethodNotFoundException
     */
    public function testCallWhenMethodExistsAndConfigured(): void
    {
        $method = 'index';

        $instance = new ControllerExample();
        $instance->setTemplator($this->createMock(Templator::class));
        $instance->setResponseFactory($this->createMock(ResponseFactory::class));

        $this->assertEquals($instance->index(), $instance->call($method));
    }

    /**
     * @covers \Coozieki\Http\Controller::setTemplator
     * @covers \Coozieki\Http\Controller::call
     * @covers \Coozieki\Http\Controller::render
     *
     * @throws MethodNotFoundException
     */
    public function testCallWhenResponseFactoryNotSet(): void
    {
        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage('ResponseFactory is not set.');

        $instance = new ControllerExample();

        $instance->setTemplator($this->createMock(Templator::class));
        $instance->call('index');
    }

    /**
     * @covers \Coozieki\Http\Controller::setResponseFactory
     * @covers \Coozieki\Http\Controller::call
     * @covers \Coozieki\Http\Controller::render
     *
     * @throws MethodNotFoundException
     */
    public function testCallWhenTemplatorNotSet(): void
    {
        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage('Templator is not set.');

        $instance = new ControllerExample();

        $instance->setResponseFactory($this->createMock(ResponseFactory::class));
        $instance->call('index');
    }

    /**
     * @covers \Coozieki\Http\Controller::setTemplator
     */
    public function testSetTemplator(): void
    {
        $templator = $this->createMock(Templator::class);

        $controller = new Controller();
        $controller->setTemplator($templator);

        $reflection = new \ReflectionObject($controller);
        $property = $reflection->getProperty('templator');
        $property->setAccessible(true);

        $property = $property->getValue($controller);

        $this->assertSame($property, $templator);
    }

    /**
     * @covers \Coozieki\Http\Controller::setResponseFactory
     */
    public function testSetResponseFactory(): void
    {
        $responseFactory = $this->createMock(ResponseFactory::class);

        $controller = new Controller();
        $controller->setResponseFactory($responseFactory);

        $reflection = new \ReflectionObject($controller);
        $property = $reflection->getProperty('responseFactory');
        $property->setAccessible(true);

        $property = $property->getValue($controller);

        $this->assertSame($property, $responseFactory);
    }
}
