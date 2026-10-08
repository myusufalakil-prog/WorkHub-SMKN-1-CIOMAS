<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Jika berjalan di lingkungan Serverless Vercel (Read-only filesystem)
$isVercel = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL') || (PHP_OS_FAMILY !== 'Windows' && is_dir('/tmp'));

if ($isVercel) {
    putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
    putenv('APP_SERVICES_CACHE=/tmp/services.php');
    putenv('APP_CONFIG_CACHE=/tmp/config.php');
    putenv('APP_ROUTES_CACHE=/tmp/routes.php');
    putenv('APP_EVENTS_CACHE=/tmp/events.php');

    $_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
    $_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
    $_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
    $_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
    $_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';

    $_SERVER['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
    $_SERVER['APP_SERVICES_CACHE'] = '/tmp/services.php';
    $_SERVER['APP_CONFIG_CACHE'] = '/tmp/config.php';
    $_SERVER['APP_ROUTES_CACHE'] = '/tmp/routes.php';
    $_SERVER['APP_EVENTS_CACHE'] = '/tmp/events.php';
}

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

if ($isVercel) {
    $app->useStoragePath('/tmp/storage');
}

return $app;
