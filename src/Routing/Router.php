<?php

namespace Coozieki\Framework\Routing;

use Coozieki\Framework\Contracts\Http\Request;
use Coozieki\Framework\Contracts\Routing\Route;
use Coozieki\Framework\Contracts\Routing\Router as RouterInterface;
use Coozieki\Framework\Exceptions\FileNotFoundException;
use Coozieki\Framework\Routing\Exceptions\NotFoundException;
use Coozieki\Framework\Support\File;

class Router implements RouterInterface
{
    public const DEFAULT_ROUTES_PATH = 'routes/web.php';

    private string $routesPath = self::DEFAULT_ROUTES_PATH;

    private string $basePath = '.';

    /**
     * @codeCoverageIgnore
     *
     * @param RoutesCollection $collection
     * @param File $file
     */
    public function __construct(private RoutesCollection $collection, private File $file)
    {
    }

    public function configure(array $config): void
    {
        $this->routesPath = $config['routesPath'] ?? $this->routesPath;
        $this->basePath = $config['basePath'] ?? $this->basePath;
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

    /**
     * @throws FileNotFoundException
     */
    public function formRouteList(): void
    {
        $routes = $this->file->requireAsArray($this->getFullRoutesPath());
        foreach ($routes as $route) {
            $this->collection->push($route);
        }
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->collection->all();
    }

    private function getFullRoutesPath(): string
    {
        return $this->file->formatPath($this->basePath.'/'.$this->routesPath);
    }
}
