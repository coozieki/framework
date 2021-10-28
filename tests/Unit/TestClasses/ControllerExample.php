<?php

namespace tests\Unit\TestClasses;

use Coozieki\Contracts\Http\Response;
use Coozieki\Exceptions\ConfigurationException;
use Coozieki\Http\Controller;

class ControllerExample extends Controller
{
    /**
     * @throws ConfigurationException
     */
    public function index(): Response
    {
        return $this->render('view');
    }
}
