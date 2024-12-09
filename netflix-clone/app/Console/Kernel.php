<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // TrustProxies middleware handles proxy headers.
        \App\Http\Middleware\TrustProxies::class,

        // Handles maintenance mode.
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // Validates the post size.
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Trims input strings.
        \App\Http\Middleware\TrimStrings::class,

        // Converts empty strings to null.
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            // Handles cookies and sessions.
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,

            // Optional middleware for "remember me" functionality.
            \Illuminate\Session\Middleware\AuthenticateSession::class,

            // Shares errors with views.
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // CSRF protection.
            \App\Http\Middleware\VerifyCsrfToken::class,

            // Routes bindings.
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Sanctum middleware for handling stateful requests.
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

            // API rate limiting.
            'throttle:api',

            // Routes bindings.
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        // Authentication middleware.
        'auth' => \App\Http\Middleware\Authenticate::class,

        // Basic authentication middleware.
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        // Authorization middleware.
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,

        // Cache headers middleware.
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        // Can middleware for checking specific abilities.
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // Guest middleware.
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // Password confirmation middleware.
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        // Signed route validation middleware.
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // Throttle middleware for rate limiting.
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Validates input parameters for bindings.
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
