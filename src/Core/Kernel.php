<?php

namespace Coozieki\Core;

use Coozieki\Contracts\Config\Configuration;
use Coozieki\Contracts\Http\ControllerFactory;
use Coozieki\Contracts\Http\Request;
use Coozieki\Contracts\Http\Response;
use Coozieki\Contracts\Http\ResponseFactory;
use Coozieki\Contracts\Routing\Router;
use Coozieki\Routing\Exceptions\NotFoundException;

class Kernel
{
    /**
     * @codeCoverageIgnore
     *
     * @param Router $router
     * @param ControllerFactory $controllerFactory
     * @param ResponseFactory $responseFactory
     * @param CoreConfiguration $configuration
     */
    public function __construct(
        private Router $router,
        private ControllerFactory $controllerFactory,
        private ResponseFactory $responseFactory,
        private CoreConfiguration $configuration
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            $this->configuration->setUp();

            $this->router->formRouteList();

            $route = $this->router->getRequestedRoute($request);

            $controller = $this->controllerFactory->create($route->getController());

            return $controller->call($route->getControllerMethod());
        } catch (NotFoundException) {
            return $this->responseFactory->notFound();
        } catch (\Exception $exception) {
            return $this->responseFactory->serverError();
        }
    }
}
