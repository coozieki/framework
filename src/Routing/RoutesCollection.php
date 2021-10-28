<?php

namespace Coozieki\Routing;

use Coozieki\Contracts\Http\Request;
use Coozieki\Support\Collection;
use Coozieki\Contracts\Routing\Route;

class RoutesCollection extends Collection
{
    /**
     * @var Route[]
     */
    protected array $elements;

    public function findRequestedRoute(Request $request): ?Route
    {
        foreach ($this->elements as $element) {
            if ($element->getUri() === $request->getRequestedUri() && $element->getHttpMethod() === $request->getMethod()) {
                return $element;
            }
        }

        return null;
    }
}
