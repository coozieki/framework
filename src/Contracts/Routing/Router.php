<?php

namespace App\Contracts\Routing;

use App\Contracts\Http\Request;

interface Router
{
    public function getRequestedRoute(Request $request): Route;
}
