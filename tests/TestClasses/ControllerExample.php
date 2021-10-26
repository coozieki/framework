<?php

namespace tests\TestClasses;

use App\Http\Controller;
use App\Http\HtmlResponse;

class ControllerExample extends Controller
{
    public function index()
    {
        return $this->render('view');
    }
}
