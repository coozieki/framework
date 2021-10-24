<?php

namespace App\Routing;

use App\Contracts\Http\Request;
use App\Support\Collection;

class RoutesCollection extends Collection
{
    public function findRequestedRoute(Request $request): ?Route
    {
        /**
         * @var Route $element
         */
        foreach ($this->elements as $element) {
            if ($element->getUri() === $request->getRequestedUri() && $element->getHttpMethod() === $request->getMethod()) {
                return $element;
            }
        }

        return null;
    }
}
