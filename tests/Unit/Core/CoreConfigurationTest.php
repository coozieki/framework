<?php

namespace tests\Unit\Core;

use Coozieki\Framework\Contracts\Config\Configuration as ConfigurationInterface;
use Coozieki\Framework\Core\App;
use Coozieki\Framework\Core\CoreConfiguration;
use Coozieki\Framework\Exceptions\ConfigurationException;
use Coozieki\Framework\Support\File;
use Exception;
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
        $configurations = [
            'configurations' => [ConfigurationExample::class, ConfigurationExample::class]
        ];

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with('config/app.php')
            ->willReturn($configurations);

        $customConfiguration = $this->createMock(ConfigurationExample::class);
        $customConfiguration->expects(self::exactly(2))
            ->method('setUp');

        $app = $this->createMock(App::class);
        $app->expects(self::exactly(2))
            ->method('make')
            ->with(ConfigurationExample::class)
            ->willReturn($customConfiguration);

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

        $configurations = [
            'configurations' => '::not_array::'
        ];

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with('config/app.php')
            ->willReturn($configurations);

        $app = $this->createMock(App::class);

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

        $configurations = [
            'configurations' => [ConfigurationExample::class, ChildClass::class]
        ];

        $file = $this->createMock(File::class);
        $file->expects(self::once())
            ->method('requireAsArray')
            ->with('config/app.php')
            ->willReturn($configurations);

        $customConfiguration = $this->createMock(ConfigurationExample::class);
        $customConfiguration->expects(self::once())
            ->method('setUp');

        $childClassInstance = $this->createMock(ChildClass::class);

        $app = $this->createMock(App::class);
        $app->expects(self::exactly(2))
            ->method('make')
            ->withConsecutive([ConfigurationExample::class], [ChildClass::class])
            ->willReturnOnConsecutiveCalls($customConfiguration, $childClassInstance);

        $configuration = new CoreConfiguration($app, $file);

        $configuration->setUp();
    }
}
