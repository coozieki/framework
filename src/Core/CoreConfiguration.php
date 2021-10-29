<?php

namespace Coozieki\Framework\Core;

use Coozieki\Framework\Config\Configuration;
use Coozieki\Framework\Exceptions\ConfigurationException;
use Coozieki\Framework\Support\File;

class CoreConfiguration extends Configuration
{
    private string $configPath = 'config/';

    private File $file;

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
        $appConfig = $this->file->requireAsArray($this->configPath . 'app.php');

        $customConfigurations = $appConfig['configurations'] ?? null;

        if (!is_array($customConfigurations)) {
            throw new ConfigurationException('$config["configurations"] must be an array of configuration classes.');
        }

        foreach ($customConfigurations as $configuration) {
            $configurationInstance = $this->app->make($configuration);

            if (!$configurationInstance instanceof Configuration) {
                throw new ConfigurationException('Custom configuration class must be instance of ' . Configuration::class . '.');
            }

            $configurationInstance->setUp();
        }
    }
}
