<?php

namespace tests\Http;

require_once __DIR__ . '/../TestClasses/ControllerExample.php';

use App\Contracts\Http\ResponseFactory;
use App\Contracts\View\Templator;
use App\Exceptions\ConfigurationException;
use App\Exceptions\MethodNotFoundException;
use App\Http\Controller;
use PHPUnit\Framework\TestCase;
use tests\TestClasses\ControllerExample;

class ControllerTest extends TestCase
{
    /**
     * @covers \App\Http\Controller::call
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
     * @covers \App\Http\Controller::call
     * @covers \App\Http\Controller::render
     * @covers \App\Http\Controller::setTemplator
     * @covers \App\Http\Controller::setResponseFactory
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
     * @covers \App\Http\Controller::setTemplator
     * @covers \App\Http\Controller::call
     * @covers \App\Http\Controller::render
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
     * @covers \App\Http\Controller::setResponseFactory
     * @covers \App\Http\Controller::call
     * @covers \App\Http\Controller::render
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
     * @covers \App\Http\Controller::setTemplator
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
     * @covers \App\Http\Controller::setResponseFactory
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
