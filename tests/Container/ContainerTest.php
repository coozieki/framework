<?php

namespace tests\Container;

require_once __DIR__ . "/../TestClasses/ParentClass.php";
require_once __DIR__ . "/../TestClasses/ChildClass.php";

use App\Container\Container;
use Container\Container as PackageContainer;
use Container\UnresolvableBindingException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use tests\TestClasses\ChildClass;
use tests\TestClasses\ParentClass;

class ContainerTest extends TestCase
{
    /**
     * @covers \App\Container\Container::singleton
     *
     * @throws UnresolvableBindingException
     */
    public function testSingleton(): void
    {
        $packageContainer = $this->createMock(PackageContainer::class);

        $abstract = ParentClass::class;
        $concrete = $this->createMock(ChildClass::class);

        $packageContainer->expects(self::once())
            ->method('singleton')
            ->with($abstract, $concrete);

        $container = new Container($packageContainer);

        $container->singleton($abstract, $concrete);
    }

    /**
     * @covers \App\Container\Container::register
     */
    public function testRegister(): void
    {
        $packageContainer = $this->createMock(PackageContainer::class);

        $abstract = ParentClass::class;
        $concrete = $this->createMock(ChildClass::class);

        $packageContainer->expects(self::once())
            ->method('bind')
            ->with($abstract, $concrete);

        $container = new Container($packageContainer);

        $container->register($abstract, $concrete);
    }

    /**
     * @covers \App\Container\Container::resolve
     *
     * @throws UnresolvableBindingException|ReflectionException
     */
    public function testResolve(): void
    {
        $packageContainer = $this->createMock(PackageContainer::class);

        $abstract = ParentClass::class;
        $concrete = $this->createMock(ParentClass::class);

        $packageContainer->expects(self::once())
            ->method('make')
            ->with($abstract)
            ->willReturn($concrete);

        $container = new Container($packageContainer);

        $this->assertEquals($concrete, $container->resolve($abstract));
    }
}