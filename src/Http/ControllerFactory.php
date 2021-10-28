<?php

namespace Coozieki\Http;

use Coozieki\Contracts\Http\Controller;
use Coozieki\Contracts\Http\ControllerFactory as ControllerFactoryInterface;
use Coozieki\Contracts\Http\ResponseFactory as ResponseFactoryInterface;
use Coozieki\Contracts\View\Templator;
use Coozieki\Core\App;

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

        if ($controllerInstance instanceof \Coozieki\Http\Controller) {
            $controllerInstance->setResponseFactory($this->app->make(ResponseFactoryInterface::class));
            $controllerInstance->setTemplator($this->app->make(Templator::class));
        }

        return $controllerInstance;
    }
}
