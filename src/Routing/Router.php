<?php

namespace App\Routing;

use App\Contracts\Http\Request;
use App\Contracts\Routing\Route;
use App\Contracts\Routing\Router as RouterInterface;
use proj\MyController;

class Router implements RouterInterface
{
    /**
     * @codeCoverageIgnore
     *
     * @param RoutesCollection $collection
     */
    public function __construct(private RoutesCollection $collection)
    {
    }

    public function getRequestedRoute(Request $request): Route
    {
        return $this->collection->findRequestedRoute($request);
    }

    //TODO: implement method
    public function formRouteList(): void
    {
        $this->collection->push(new \App\Routing\Route('/index', MyController::class, 'index', 'GET'));
    }
}
