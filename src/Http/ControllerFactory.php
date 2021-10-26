<?php

namespace App\Http;

use App\Contracts\Http\Controller;
use App\Contracts\Http\ControllerFactory as ControllerFactoryInterface;
use App\Contracts\Http\ResponseFactory as ResponseFactoryInterface;
use App\Contracts\View\Templator;
use App\Core\App;

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

        if ($controllerInstance instanceof \App\Http\Controller) {
            $controllerInstance->setResponseFactory($this->app->make(ResponseFactoryInterface::class));
            $controllerInstance->setTemplator($this->app->make(Templator::class));
        }

        return $controllerInstance;
    }
}
