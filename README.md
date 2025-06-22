Web Application Security - Assignment 4

Task 1: Implement Content Security Policy (CSP)

Laravel official docs don’t provide built-in native CSP middleware out of the box yet. Instead, Laravel recommends using middleware or third-party packages to implement CSP headers. The package spatie/laravel-csp is the community standard approach and is widely accepted.
 
* Install Spatie: [spatie/laravel-csp](https://github.com/spatie/laravel-csp):

```bash
composer require spatie/laravel-csp
```

* Publish config and middleware:

```bash
php artisan vendor:publish --provider="Spatie\Csp\CspServiceProvider"
```

* Add the middleware in `app/Http/Kernel.php`:

```php
use Spatie\Csp\AddCspHeaders;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            AddCspHeaders::class,
            // ...
        ],
    ];
```

* Configure CSP policies in `config/csp.php`:

```php
return [
    'policies' => [
        \Spatie\Csp\Policies\Basic::class,
        \App\Csp\CustomPolicy::class, 
    ],
];
```

* Create `app/Csp/CustomPolicy.php`:

```php
class CustomPolicy extends Policy
{
    public function configure()
    {
        $this->addDirective('default-src', ['\'self\''])
             ->addDirective('script-src', ['\'self\''])
             ->addDirective('style-src', ['\'self\'', 'fonts.bunny.net'])
             ->addDirective('font-src', ['fonts.bunny.net'])
             ->addDirective('img-src', ['\'self\'', 'data:']);
    }
}
```

This restricts all sources to the same origin except styles and fonts from `fonts.bunny.net`.

Task 2: Implement XSS Defense

Laravel’s Blade automatically escapes output with {{ }}, as documented here:
[https://laravel.com/docs/blade#displaying-data](https://laravel.com/docs/blade#displaying-data)

* Always use `{{ $variable }}` for output — this escapes HTML special characters, instead of `{!! $variable !!}`.

Task 3: Implement CSRF Defense

Laravel has built-in CSRF protection middleware enabled by default on all web routes and the @csrf Blade directive for forms, documented here: [https://laravel.com/docs/csrf](https://laravel.com/docs/csrf) 

* Include CSRF token in all Blade forms

```blade
<form method="POST" action="/todos">
    @csrf
    <!-- other inputs -->
</form>
```

* Add in HTML head:

```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
```

* Verify the CSRF middleware is enabled in `app/Http/Kernel.php`:

```php
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            VerifyCsrfToken::class,
            // ...
        ],
    ];
```



