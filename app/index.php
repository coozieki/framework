<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\App;
use App\Container\Container;
use Container\Container as PackageContainer;

$app = new App(new Container(new PackageContainer()));

$app->singleton(Exception::class, new Exception("123"));

var_dump($app->make(Exception::class));