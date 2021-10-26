<?php

namespace App\Http;

use App\Contracts\Http\Controller;
use App\Contracts\Http\ControllerFactory as ControllerFactoryInterface;
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
        return $this->app->make($controller);
    }
}
