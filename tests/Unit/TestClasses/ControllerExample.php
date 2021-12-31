<?php

namespace tests\Unit\TestClasses;

use Coozieki\Framework\Contracts\Http\Response;
use Coozieki\Framework\Http\Controller;

class ControllerExample extends Controller
{
    public function index(): Response
    {
        return $this->render('view');
    }
}
