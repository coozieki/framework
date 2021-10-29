<?php

namespace Coozieki\Framework\Config;

use Coozieki\Framework\Contracts\Config\Configuration as ConfigurationInterface;
use Coozieki\Framework\Core\App;

/**
 * @codeCoverageIgnore
 */
abstract class Configuration implements ConfigurationInterface
{
    public function __construct(protected App $app)
    {

    }
}
