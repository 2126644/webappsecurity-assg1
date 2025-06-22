1. Implement Content Security Policy (CSP) in Laravel

CSP helps prevent injection attacks by restricting resources the browser can load.

* Use a Laravel Middleware Package
  You can use a package like [spatie/laravel-csp](https://github.com/spatie/laravel-csp):

```bash
composer require spatie/laravel-csp
```

* Publish config and middleware:

```bash
php artisan vendor:publish --provider="Spatie\Csp\CspServiceProvider"
```

* Add the middleware in `app/Http/Kernel.php` (for web routes):

```php
protected $middlewareGroups = [
    'web' => [
        // other middlewares ...
        \Spatie\Csp\AddCspHeaders::class,
    ],
];
```

* Configure CSP policies in `config/csp.php`, example:

```php
return [
    'policies' => [
        \Spatie\Csp\Policies\Basic::class,
        \App\Csp\CustomPolicy::class, 
    ],
];
```

* For a custom policy, create `app/Csp/CustomPolicy.php`:

```php
<?php

namespace App\Csp;

use Spatie\Csp\Policies\Policy;

class CustomPolicy extends Policy
{
    public function configure()
    {
        $this->addDirective('default-src', ['\'self\''])
             ->addDirective('script-src', ['\'self\''])
             ->addDirective('style-src', ['\'self\'', 'fonts.googleapis.com'])
             ->addDirective('font-src', ['fonts.gstatic.com'])
             ->addDirective('img-src', ['\'self\'', 'data:']);
    }
}
```

This restricts all sources to the same origin except styles and fonts from Google Fonts and images from the same origin or inline data.

---

2. Implement XSS Defense in Laravel

Laravel automatically escapes output in Blade templates by default when you use `{{ $variable }}` instead of `{!! $variable !!}`.

* Escape output in Blade views
  Use `{{ $variable }}` for output — this escapes HTML special characters.

* Avoid `{!! $variable !!}` unless safe
  Only use unescaped output if you trust the content (e.g., sanitized or trusted HTML).

---

3. Implement CSRF Defense in Laravel

Laravel has built-in CSRF protection middleware enabled by default on all web routes.


* Include CSRF token in all forms
  In Blade forms, always include:

```blade
<form method="POST" action="/todos">
    @csrf
    <!-- other inputs -->
</form>
```

The `@csrf` directive outputs a hidden input with the CSRF token.

And add in your HTML head:

```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
```

* Verify the CSRF middleware is enabled
  Check `app/Http/Kernel.php` for:

```php
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\VerifyCsrfToken::class,
        // ...
    ],
];
```



