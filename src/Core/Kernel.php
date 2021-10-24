<?php

namespace App\Core;

use App\Contracts\Http\ControllerInvoker;
use App\Contracts\Http\Request;
use App\Contracts\Http\Response;
use App\Contracts\Routing\Router;

class Kernel
{
    /**
     * @codeCoverageIgnore
     *
     * @param Router $router
     * @param ControllerInvoker $controllerInvoker
     */
    public function __construct(private Router $router, private ControllerInvoker $controllerInvoker)
    {
    }

    public function handle(Request $request): Response
    {
        $this->router->formRouteList();

        $route = $this->router->getRequestedRoute($request);

        return $this->controllerInvoker->invoke($route->getController(), $route->getControllerMethod());
    }
}
