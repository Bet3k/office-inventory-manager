# Laravel + Inertia + React Starter Kit

A starter kit using Laravel, Inertia.js, and React. Preconfigured with essential tools for development, debugging,
static analysis, and UI components.

---

## Tech Stack

- [Laravel](https://laravel.com/)
- [Inertia.js](https://inertiajs.com/)
- [React](https://react.dev/)
- [shadcn/ui](https://ui.shadcn.com/)

## Authentication

- [Laravel Fortify](https://laravel.com/docs/12.x/fortify#main-content) – Only handles login with or without 2FA.
- [Laravel Socialite](https://laravel.com/docs/12.x/socialite#main-content) – Provides OAuth authentication with
  providers like GitHub, Google, etc. Currently, app only configured to use Google.

---

## Developer Tools

### Debugging

- [Laravel Debugbar](https://laraveldebugbar.com/)  
  Only enabled in development when `APP_DEBUG=true`.

- [Log Viewer](https://log-viewer.opcodes.io/)  
  Available in both development and production. Can be disabled via `.env`:

  ```env
  LOG_VIEWER_ENABLED=false

### Static Analysis and Code Style

- [PHPStan](https://phpstan.org/)  
  Static analysis for PHP. Development only.

- [PHP Insights](https://github.com/nunomaduro/phpinsights)  
  Code quality and architecture analysis. Development only.

- [Laravel Pint](https://laravel.com/docs/12.x/pint)  
  Code style fixer. Development only.

---

## PHPStorm File Watcher

Configure a file watcher in PHPStorm to automatically run the following tools on file save:

- Laravel Pint
- PHPStan
- PHP Insights

---

## Getting Started

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Copy environment config and generate app key
cp .env.example .env
php artisan key:generate

# Run local development servers
php artisan serve
npm run dev
```

---

## Documentation

- [Laravel](https://laravel.com/)
- [Inertia.js](https://inertiajs.com/)
- [React](https://react.dev/)
- [Laravel Debugbar](https://laraveldebugbar.com/)
- [Log Viewer](https://log-viewer.opcodes.io/)
- [PHPStan](https://phpstan.org/)
- [PHP Insights](https://github.com/nunomaduro/phpinsights)
- [Laravel Pint](https://laravel.com/docs/12.x/pint)
- [shadcn/ui](https://ui.shadcn.com/)
- [Laravel Socialite](https://laravel.com/docs/12.x/socialite#main-content)
- [Laravel Fortify](https://laravel.com/docs/12.x/fortify#main-content)
