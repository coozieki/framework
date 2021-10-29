<?php

namespace Coozieki\Framework\Core;

use Coozieki\Framework\Config\Configuration;
use Coozieki\Framework\Exceptions\ConfigurationException;

class CoreConfiguration extends Configuration
{
    private string $configPath = 'config/';

    /**
     * @throws ConfigurationException
     */
    public function setUp(): void
    {
        $appConfig = require $this->configPath . 'app.php';

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
