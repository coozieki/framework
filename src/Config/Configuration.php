<?php

namespace Coozieki\Config;

use Coozieki\Contracts\Config\Configuration as ConfigurationInterface;
use Coozieki\Core\App;

/**
 * @codeCoverageIgnore
 */
abstract class Configuration implements ConfigurationInterface
{
    final public function __construct(protected App $app)
    {

    }
}
