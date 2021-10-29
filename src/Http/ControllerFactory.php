<?php

namespace Coozieki\Framework\Http;

use Coozieki\Framework\Contracts\Http\Controller;
use Coozieki\Framework\Contracts\Http\ControllerFactory as ControllerFactoryInterface;
use Coozieki\Framework\Contracts\Http\ResponseFactory as ResponseFactoryInterface;
use Coozieki\Framework\Contracts\View\Templator;
use Coozieki\Framework\Core\App;

class ControllerFactory implements ControllerFactoryInterface
{
    /**
     * @codeCoverageIgnore
     *
     * @param App $app
     */
    public function __construct(private App $app)
    {
    }

    public function create(string $controller): Controller
    {
        $controllerInstance = $this->app->make($controller);

        if ($controllerInstance instanceof \Coozieki\Framework\Http\Controller) {
            $controllerInstance->setResponseFactory($this->app->make(ResponseFactoryInterface::class));
            $controllerInstance->setTemplator($this->app->make(Templator::class));
        }

        return $controllerInstance;
    }
}
