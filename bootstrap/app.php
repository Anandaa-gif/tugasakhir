<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


// 👉 Tambahkan baris ini untuk menggunakan Schedule\Kernel
use App\Console\Kernel as ConsoleKernel;
use Illuminate\Contracts\Console\Kernel as KernelContract;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'anggota' => \App\Http\Middleware\usermiddleware::class,
            'admin' => \App\Http\Middleware\adminmiddleware::class,
            'ceksudahanggota' => \App\Http\Middleware\CekSudahAnggota::class,
        ]);
    })
    ->withBindings([
        KernelContract::class => ConsoleKernel::class, 
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
