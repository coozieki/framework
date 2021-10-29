<?php

namespace Coozieki\Framework\Routing;

use Coozieki\Framework\Contracts\Http\Request;
use Coozieki\Framework\Contracts\Routing\Route;
use Coozieki\Framework\Contracts\Routing\Router as RouterInterface;
use Coozieki\Framework\Routing\Exceptions\NotFoundException;
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
        $this->collection->push(new \Coozieki\Framework\Routing\Route('/index', MyController::class, 'index', 'GET'));
        $this->collection->push(new \Coozieki\Framework\Routing\Route('/post', MyController::class, 'post', 'POST'));
    }

    public function getRoutes(): array
    {
        return $this->collection->all();
    }
}
