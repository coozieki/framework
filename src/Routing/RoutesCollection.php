<?php

namespace App\Routing;

use App\Support\Collection;

class RoutesCollection extends Collection
{
    public function findByUri(string $uri): ?Route
    {
        foreach ($this->elements as $element) {
            if ($element->getUri() === $uri) {
                return $element;
            }
        }

        return null;
    }
}
