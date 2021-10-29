<?php

namespace Coozieki\Framework\Routing;

use Coozieki\Framework\Contracts\Http\Request;
use Coozieki\Framework\Support\Collection;
use Coozieki\Framework\Contracts\Routing\Route;

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
