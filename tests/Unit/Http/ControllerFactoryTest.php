<?php

namespace tests\Unit\Http;

use Coozieki\Contracts\Http\Controller;
use Coozieki\Contracts\Http\ResponseFactory;
use Coozieki\Contracts\View\Templator;
use Coozieki\Core\App;
use Coozieki\Http\ControllerFactory;
use PHPUnit\Framework\TestCase;

class ControllerFactoryTest extends TestCase
{
    /**
     * @dataProvider controllerDataProvider
     *
     * @covers \Coozieki\Http\ControllerFactory::create
     */
    public function testCreateWhenControllerExists(string $controller): void
    {
        $controllerInstance = $this->createMock($controller);

        $app = $this->createMock(App::class);

        if (is_subclass_of($controllerInstance, \Coozieki\Http\Controller::class)) {
            $templator = $this->createMock(Templator::class);
            $responseFactory = $this->createMock(ResponseFactory::class);

            $app->expects(self::exactly(3))
                ->method('make')
                ->withConsecutive([$controller], [ResponseFactory::class], [Templator::class])
                ->willReturnOnConsecutiveCalls($controllerInstance, $responseFactory, $templator);

            $controllerInstance->expects(self::once())
                ->method('setTemplator')
                ->with($templator);
            $controllerInstance->expects(self::once())
                ->method('setResponseFactory')
                ->with($responseFactory);
        } else {
            $app->expects(self::once())
                ->method('make')
                ->with($controller)
                ->willReturn($controllerInstance);
        }

        $factory = new ControllerFactory($app);

        $this->assertEquals($controllerInstance, $factory->create($controller));
    }

    public function controllerDataProvider(): array
    {
        return [
            [Controller::class],
            [\Coozieki\Http\Controller::class]
        ];
    }
}
