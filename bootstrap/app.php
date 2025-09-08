<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminOrRecruiterMiddleware;
use App\Http\Middleware\Recruiter;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            "recruiter" => Recruiter::class,
            "admin" => AdminMiddleware::class,
            "adminOrRecruiter" => AdminOrRecruiterMiddleware::class
        ]); 
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
