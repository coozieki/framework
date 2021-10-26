<?php

namespace tests\Http;

use App\Contracts\Http\Controller;
use App\Core\App;
use App\Http\ControllerFactory;
use PHPUnit\Framework\TestCase;

class ControllerFactoryTest extends TestCase
{
    /**
     * @covers \App\Http\ControllerFactory::create
     */
    public function testCreate(): void
    {
        $controller = '::controller::';
        $controllerInstance = $this->createMock(Controller::class);

        $app = $this->createMock(App::class);
        $app->expects(self::once())
            ->method('make')
            ->with($controller)
            ->willReturn($controllerInstance);

        $factory = new ControllerFactory($app);

        $this->assertEquals($controllerInstance, $factory->create($controller));
    }
}
