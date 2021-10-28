<?php

use Coozieki\Core\App;
use Coozieki\Core\Kernel;

$container = new \Coozieki\Container\Container(new \Container\Container());

$app = new App($container);

$app->bind(\Coozieki\Contracts\Http\Request::class, \Coozieki\Http\Request::class);
$app->bind(\Coozieki\Contracts\Http\ControllerFactory::class, \Coozieki\Http\ControllerFactory::class);
$app->bind(\Coozieki\Contracts\Routing\Route::class, \Coozieki\Routing\Route::class);
$app->bind(\Coozieki\Contracts\Http\ResponseFactory::class, \Coozieki\Http\ResponseFactory::class);
$app->bind(\Coozieki\Contracts\View\Templator::class, \Coozieki\View\BaseTemplator::class);

$app->singleton(App::class, $app);
$app->singleton(\Coozieki\Contracts\Routing\Router::class, $app->make(\Coozieki\Routing\Router::class));
$app->singleton(Kernel::class, $app->make(Kernel::class));