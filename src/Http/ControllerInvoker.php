<?php

namespace App\Http;

use App\Contracts\Http\ControllerInvoker as ControllerInvokerInterface;
use App\Contracts\Http\Response;
use App\Core\App;

class ControllerInvoker implements ControllerInvokerInterface
{
    /**
     * @codeCoverageIgnore
     *
     * @param App $app
     */
    public function __construct(private App $app)
    {
    }

    public function invoke(string $controller, string $method): Response
    {
        $controller = $this->app->make($controller);

        return $controller->$method();
    }
}
