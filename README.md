# Laravel + Inertia + React Office Device Manager

Using the [Starter Kit](https://github.com/IsaacHatilima/starter-with-auth), this application was built to help
organizations efficiently manage and keep track of their office hardware inventory. It allows administrators to add,
update, and monitor various devices such as laptops, desktops, tablets, printers, and other office equipment.

Each device has a status that indicates its condition — whether it is Functional, Non-Functional, or In-Repair — and a
service status that shows whether the device is Assigned to a member of staff, Available for use, or Decommissioned.

The app also supports creating and managing members of staff, allowing administrators to assign devices directly to
staff members. This enables clear visibility into who is using which device, and helps track changes over time.

Built with maintainability and clarity in mind, the system supports searchable, paginated device listings, robust form
validation, and transactional updates to ensure consistency across device and assignment data.

---

## Tech Stack

- [Laravel](https://laravel.com/)
- [Inertia.js](https://inertiajs.com/)
- [React](https://react.dev/)
- [shadcn/ui](https://ui.shadcn.com/)

## Authentication

- [Laravel Fortify](https://laravel.com/docs/12.x/fortify#main-content) – Only handles login with or without 2FA.

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
