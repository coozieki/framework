<?php

namespace Coozieki\Framework\Core;

use Coozieki\Framework\Config\Configuration;
use Coozieki\Framework\Contracts\Config\Configuration as ConfigurationInterface;
use Coozieki\Framework\Contracts\View\Templator;
use Coozieki\Framework\Exceptions\ConfigurationException;
use Coozieki\Framework\Exceptions\FileNotFoundException;
use Coozieki\Framework\Contracts\Routing\Router;
use Coozieki\Framework\Support\File;

class CoreConfiguration extends Configuration
{
    private string $configPath = 'config/';

    private File $file;

    /**
     * @codeCoverageIgnore
     *
     * @param App $app
     * @param File $file
     */
    public function __construct(App $app, File $file)
    {
        $this->file = $file;
        parent::__construct($app);
    }

    /**
     * @throws ConfigurationException
     */
    public function setUp(): void
    {
        try {
            $appConfig = $this->file->requireAsArray($this->configPath . 'app.php');
        } catch (FileNotFoundException) {
            return;
        }

        $customConfigurations = $appConfig['configurations'] ?? [];

        if (!is_array($customConfigurations)) {
            throw new ConfigurationException('$config["configurations"] must be an array of configuration classes.');
        }

        foreach ($customConfigurations as $configuration) {
            $configurationInstance = $this->app->make($configuration);

            if (!$configurationInstance instanceof ConfigurationInterface) {
                throw new ConfigurationException('Custom configuration class must be instance of ' . ConfigurationInterface::class . '.');
            }

            $configurationInstance->setUp();
        }

        $this->app->make(Router::class)->configure($appConfig);
        $this->app->make(Templator::class)->configure($appConfig);
    }
}
