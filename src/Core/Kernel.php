<?php

namespace App\Core;

use App\Contracts\Http\ControllerFactory;
use App\Contracts\Http\Request;
use App\Contracts\Http\Response;
use App\Contracts\Routing\Router;

class Kernel
{
    /**
     * @codeCoverageIgnore
     *
     * @param Router $router
     * @param ControllerFactory $controllerFactory
     */
    public function __construct(
        private Router $router,
        private ControllerFactory $controllerFactory
    ) {
    }

    public function handle(Request $request): Response
    {
        $this->router->formRouteList();

        $route = $this->router->getRequestedRoute($request);

        $controller = $this->controllerFactory->create($route->getController());

        return $controller->call($route->getControllerMethod());
    }
}
