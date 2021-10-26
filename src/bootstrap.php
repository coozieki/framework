<?php

use App\Core\App;
use App\Core\Kernel;

$container = new \App\Container\Container(new \Container\Container());

/**
 * @var App $app
 */
$app = new App($container);

$app->bind(\App\Contracts\Http\Request::class, \App\Http\Request::class);
$app->bind(\App\Contracts\Http\ControllerFactory::class, \App\Http\ControllerFactory::class);
$app->bind(\App\Contracts\Routing\Route::class, \App\Routing\Route::class);
$app->bind(\App\Contracts\Http\ResponseFactory::class, \App\Http\ResponseFactory::class);

$app->singleton(App::class, $app);
$app->singleton(\App\Contracts\Routing\Router::class, $app->make(\App\Routing\Router::class));
$app->singleton(Kernel::class, $app->make(Kernel::class));