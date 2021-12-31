<?php

use Coozieki\Framework\Core\App;
use Coozieki\Framework\Core\Kernel;

$container = new \Coozieki\Framework\Container\Container(new \Container\Container());

$app = new App($container);

$app->bind(\Coozieki\Framework\Contracts\Http\Request::class, \Coozieki\Framework\Http\Request::class);
$app->bind(\Coozieki\Framework\Contracts\Http\ControllerFactory::class, \Coozieki\Framework\Http\ControllerFactory::class);
$app->bind(\Coozieki\Framework\Contracts\Routing\Route::class, \Coozieki\Framework\Routing\Route::class);
$app->bind(\Coozieki\Framework\Contracts\Http\ResponseFactory::class, \Coozieki\Framework\Http\ResponseFactory::class);
$app->bind(\Coozieki\Framework\Contracts\View\Templator::class, \Coozieki\Framework\View\SimpleTemplator::class);

$app->singleton(App::class, $app);
$app->singleton(\Coozieki\Framework\Contracts\Routing\Router::class, $app->make(\Coozieki\Framework\Routing\Router::class));
$app->singleton(Kernel::class, $app->make(Kernel::class));