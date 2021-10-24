<?php

namespace App\Routing;

use App\Contracts\Http\Request;
use App\Support\Collection;
use App\Contracts\Routing\Route;

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
