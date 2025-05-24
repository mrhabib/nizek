<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Providers\RepositoryServiceProvider;
use App\Providers\ScheduleServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        RepositoryServiceProvider::class,
        ScheduleServiceProvider::class,
    ])
    ->withRouting(
        //web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
