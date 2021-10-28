<?php

namespace Coozieki\Routing;

use Coozieki\Contracts\Http\Request;
use Coozieki\Contracts\Routing\Route;
use Coozieki\Contracts\Routing\Router as RouterInterface;
use Coozieki\Routing\Exceptions\NotFoundException;
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

    /**
     * @throws NotFoundException
     */
    public function getRequestedRoute(Request $request): Route
    {
        $route =  $this->collection->findRequestedRoute($request);
        if ($route === null) {
            throw new NotFoundException();
        }

        return $route;
    }

    //TODO: implement method
    public function formRouteList(): void
    {
        $this->collection->push(new \Coozieki\Routing\Route('/index', MyController::class, 'index', 'GET'));
        $this->collection->push(new \Coozieki\Routing\Route('/post', MyController::class, 'post', 'POST'));
    }

    public function getRoutes(): array
    {
        return $this->collection->all();
    }
}
