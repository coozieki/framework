<?php

namespace tests\TestClasses;

use App\Contracts\Http\Response;
use App\Exceptions\ConfigurationException;
use App\Http\Controller;

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
