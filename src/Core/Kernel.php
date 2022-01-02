<?php

namespace Coozieki\Framework\Core;

use Coozieki\Framework\Contracts\Http\ControllerFactory;
use Coozieki\Framework\Contracts\Http\Request;
use Coozieki\Framework\Contracts\Http\Response;
use Coozieki\Framework\Contracts\Http\ResponseFactory;
use Coozieki\Framework\Contracts\Routing\Router;
use Coozieki\Framework\Routing\Exceptions\NotFoundException;

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
            throw $exception;
        }
    }
}
