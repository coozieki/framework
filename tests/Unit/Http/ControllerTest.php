<?php

namespace tests\Unit\Http;

require_once __DIR__ . '/../TestClasses/ControllerExample.php';

use Coozieki\Framework\Contracts\Http\ResponseFactory;
use Coozieki\Framework\Contracts\View\Templator;
use Coozieki\Framework\Exceptions\ConfigurationException;
use Coozieki\Framework\Exceptions\MethodNotFoundException;
use Coozieki\Framework\Http\Controller;
use PHPUnit\Framework\TestCase;
use tests\Unit\TestClasses\ControllerExample;

class ControllerTest extends TestCase
{
    /**
     * @covers \Coozieki\Framework\Http\Controller::call
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
     * @covers \Coozieki\Framework\Http\Controller::call
     * @covers \Coozieki\Framework\Http\Controller::render
     * @covers \Coozieki\Framework\Http\Controller::setTemplator
     * @covers \Coozieki\Framework\Http\Controller::setResponseFactory
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
     * @covers \Coozieki\Framework\Http\Controller::setTemplator
     * @covers \Coozieki\Framework\Http\Controller::call
     * @covers \Coozieki\Framework\Http\Controller::render
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
     * @covers \Coozieki\Framework\Http\Controller::setResponseFactory
     * @covers \Coozieki\Framework\Http\Controller::call
     * @covers \Coozieki\Framework\Http\Controller::render
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
     * @covers \Coozieki\Framework\Http\Controller::setTemplator
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
     * @covers \Coozieki\Framework\Http\Controller::setResponseFactory
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
