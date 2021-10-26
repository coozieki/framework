<?php

namespace App\Contracts\Routing;

use App\Contracts\Http\Request;

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
