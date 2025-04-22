<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    // Register route middleware aliases
    $middleware->alias([
        'admin.auth' => \App\Http\Middleware\AdminAuthMiddleware::class,
        'member.auth' => \App\Http\Middleware\MemberAuthMiddleware::class,
    ]);

    // Register global middleware here
    $middleware->append([
        \App\Http\Middleware\LogVisitor::class,
    ]);
})

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

