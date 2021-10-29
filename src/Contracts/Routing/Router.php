<?php

namespace Coozieki\Framework\Contracts\Routing;

use Coozieki\Framework\Contracts\Http\Request;

interface Router
{
    /**
     * Gets current request route
     *
     * @param Request $request
     * @return Route
     */
    public function getRequestedRoute(Request $request): Route;

    public function formRouteList();

    public function getRoutes(): array;
}
