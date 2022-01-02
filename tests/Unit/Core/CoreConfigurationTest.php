<?php

namespace tests\Unit\Core;

use Coozieki\Framework\Contracts\Config\Configuration as ConfigurationInterface;
use Coozieki\Framework\Contracts\View\Templator;
use Coozieki\Framework\Core\App;
use Coozieki\Framework\Core\CoreConfiguration;
use Coozieki\Framework\Exceptions\ConfigurationException;
use Coozieki\Framework\Exceptions\FileNotFoundException;
use Coozieki\Framework\Contracts\Routing\Router;
use Coozieki\Framework\Support\File;
use PHPUnit\Framework\TestCase;
use tests\Unit\TestClasses\ChildClass;
use tests\Unit\TestClasses\ConfigurationExample;

class CoreConfigurationTest extends TestCase
{
    /**
     * @covers \Coozieki\Framework\Core\CoreConfiguration::setUp
     *
     * @throws ConfigurationException
     */
    public function testSetUpWhenConfigurationsIsArrayAndNoErrors(): void
    {
        $basePath = getcwd();
        $fullPath = $basePath.'/config/app.php';

        $configurations = [
            'configurations' => [ConfigurationExample::class, ConfigurationExample::class]
        ];
        $resultConfig = [
            'configurations' => $configurations['configurations'],
            'basePath' => $basePath
        ];

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('formatPath')
            ->with($fullPath)
            ->willReturn($fullPath);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with($fullPath)
            ->willReturn($configurations);

        $customConfiguration = $this->createMock(ConfigurationExample::class);
        $customConfiguration->expects(self::exactly(2))
            ->method('setUp');

        $router = $this->createMock(Router::class);
        $router->expects(self::once())
            ->method('configure')
            ->with($resultConfig);

        $templator = $this->createMock(Templator::class);
        $templator->expects(self::once())
            ->method('configure')
            ->with($resultConfig);

        $app = $this->createMock(App::class);
        $app->expects(self::once())
            ->method('getBasePath')
            ->willReturn($basePath);
        $app->expects(self::exactly(4))
            ->method('make')
            ->withConsecutive(
                [ConfigurationExample::class],
                [ConfigurationExample::class],
                [Router::class],
                [Templator::class]
            )
            ->willReturn(
                $customConfiguration,
                $customConfiguration,
                $router,
                $templator
            );

        $configuration = new CoreConfiguration($app, $file);

        $configuration->setUp();
    }

    /**
     * @covers \Coozieki\Framework\Core\CoreConfiguration::setUp
     *
     * @throws ConfigurationException
     */
    public function testSetUpWhenConfigurationsIsNotArray(): void
    {
        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage('$config["configurations"] must be an array of configuration classes.');

        $basePath = getcwd();
        $fullPath = $basePath.'/config/app.php';

        $configurations = [
            'configurations' => '::not_array::'
        ];

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('formatPath')
            ->with($fullPath)
            ->willReturn($fullPath);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with($fullPath)
            ->willReturn($configurations);

        $app = $this->createMock(App::class);
        $app->expects(self::once())
            ->method('getBasePath')
            ->willReturn($basePath);

        $configuration = new CoreConfiguration($app, $file);

        $configuration->setUp();
    }

    /**
     * @covers \Coozieki\Framework\Core\CoreConfiguration::setUp
     *
     * @throws ConfigurationException
     */
    public function testSetUpWhenConfigurationsIsArrayAndHasIncorrectTypes(): void
    {
        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage('Custom configuration class must be instance of ' . ConfigurationInterface::class . '.');

        $basePath = getcwd();
        $fullPath = $basePath.'/config/app.php';

        $configurations = [
            'configurations' => [ConfigurationExample::class, ChildClass::class]
        ];

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('formatPath')
            ->with($fullPath)
            ->willReturn($fullPath);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with($fullPath)
            ->willReturn($configurations);

        $customConfiguration = $this->createMock(ConfigurationExample::class);
        $customConfiguration->expects(self::once())
            ->method('setUp');

        $childClassInstance = $this->createMock(ChildClass::class);

        $app = $this->createMock(App::class);
        $app->expects(self::once())
            ->method('getBasePath')
            ->willReturn($basePath);
        $app->expects(self::exactly(2))
            ->method('make')
            ->withConsecutive([ConfigurationExample::class], [ChildClass::class])
            ->willReturnOnConsecutiveCalls($customConfiguration, $childClassInstance);

        $configuration = new CoreConfiguration($app, $file);

        $configuration->setUp();
    }

    /**
     * @covers \Coozieki\Framework\Core\CoreConfiguration::setUp
     *
     * @throws ConfigurationException
     */
    public function testSetUpWhenConfigurationsIsEmpty(): void
    {
        $basePath = getcwd();
        $fullPath = $basePath.'/config/app.php';

        $configurations = [];
        $resultConfig = [
            'basePath' => $basePath
        ];

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('formatPath')
            ->with($fullPath)
            ->willReturn($fullPath);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with($fullPath)
            ->willReturn($configurations);

        $router = $this->createMock(Router::class);
        $router->expects(self::once())
            ->method('configure')
            ->with($resultConfig);

        $templator = $this->createMock(Templator::class);
        $templator->expects(self::once())
            ->method('configure')
            ->with($resultConfig);

        $app = $this->createMock(App::class);
        $app->expects(self::once())
            ->method('getBasePath')
            ->willReturn($basePath);
        $app->expects(self::exactly(2))
            ->method('make')
            ->withConsecutive(
                [Router::class],
                [Templator::class]
            )
            ->willReturn(
                $router,
                $templator
            );

        $configuration = new CoreConfiguration($app, $file);

        $configuration->setUp();
    }

    /**
     * @covers \Coozieki\Framework\Core\CoreConfiguration::setUp
     *
     * @throws ConfigurationException
     */
    public function testSetUpWhenConfigFileDoesntExist(): void
    {
        $basePath = getcwd();
        $fullPath = $basePath.'/config/app.php';

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('formatPath')
            ->with($fullPath)
            ->willReturn($fullPath);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with($fullPath)
            ->willThrowException(new FileNotFoundException());

        $app = $this->createMock(App::class);
        $app->expects(self::once())
            ->method('getBasePath')
            ->willReturn($basePath);

        $configuration = new CoreConfiguration($app, $file);

        $configuration->setUp();
    }
}
