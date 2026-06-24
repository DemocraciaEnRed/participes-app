# Package Compatibility Matrix

Use this as the working inventory while upgrading from Laravel 8 to Laravel 13. Exact target versions should be confirmed with `composer update --dry-run` at each major step.

## Composer Packages

| Package | Current Constraint | Upgrade Track | Notes |
| --- | --- | --- | --- |
| `php` | `^7.3|^8.0` | 8.0.2+ for Laravel 9, 8.1+ for 10, 8.2+ for 11 | Final Laravel 13 runtime should be chosen before dependency work begins. |
| `laravel/framework` | `^8.0` | `^9.0` -> `^10.0` -> `^11.0` -> `^12.0` -> `^13.0` | Upgrade one major at a time. |
| `laravel/tinker` | `^2.0` | Keep compatible until Laravel 13, then `^3.0` | Laravel 13 guide calls out `^3.0`. |
| `facade/ignition` | `^2.3.6` | Remove at Laravel 9 | Replace with `spatie/laravel-ignition`. |
| `spatie/laravel-ignition` | not installed | `^1.0` for Laravel 9, `^2.0` for Laravel 10+ | Dev-only replacement for Ignition. |
| `nunomaduro/collision` | `^5.0` | `^6.1` -> `^7.0` -> `^8.1` | Pair with framework / PHPUnit jumps. |
| `phpunit/phpunit` | `^9.0` | Consider `^10.0` at Laravel 10, `^11.0` at Laravel 12, `^12.0` at Laravel 13 | PHPUnit upgrades may require test-suite config changes. |
| `laravel/ui` | `^3.0` | `^4.0` at Laravel 10 if retained | Longer-term auth scaffolding replacement may be cleaner, but not required for the first pass. |
| `fideloper/proxy` | `^4.2` | Remove | Modern Laravel includes trusted proxy middleware support. |
| `fruitcake/laravel-cors` | `^1.0` | Remove | Replace middleware usage with framework CORS middleware. |
| `guzzlehttp/guzzle` | `^7.0.1` | Keep on supported 7.x | Verify conflicts only. |
| `intervention/image` | `^2.5` | Verify Laravel 10+ / PHP 8.2 support | May require major upgrade and facade/config changes. |
| `maatwebsite/excel` | `^3.1` | Verify latest 3.1 / 4.x support per Laravel target | Exports are core admin/report functionality. |
| `predis/predis` | `^1.1` | Consider `^2.x` if needed | Repo config defaults Redis client to `phpredis`; confirm production runtime. |
| `anhskohbo/no-captcha` | `^3.2` | Verify Laravel 9-13 compatibility | Form validation / captcha smoke tests required. |
| `barryvdh/laravel-debugbar` | `^3.5` | Upgrade progressively or remove from upgrade branch | Dev-only package, but config/provider aliases are registered in the app. |
| `fakerphp/faker` | `^1.9` | Keep current compatible release unless conflicts require bump | Dev-only. |
| `mockery/mockery` | `^1.3.1` | Bump with PHPUnit if needed | Dev-only. |

## App Code Hotspots

| Area | Files | Upgrade Concern |
| --- | --- | --- |
| CORS middleware | `app/Http/Kernel.php` | Uses `Fruitcake\Cors\HandleCors`; replace during Laravel 9 work. |
| Manual providers / aliases | `config/app.php` | Debugbar, Intervention Image, NoCaptcha aliases/providers may change with package upgrades. |
| Eloquent `$dates` | `app/ActionLog.php`, `app/Event.php`, `app/Milestone.php`, `app/Report.php` | Convert to `$casts` before or during Laravel 10. |
| Custom logging | `app/Logging/MySQLCustomLogger.php`, `app/Logging/MySQLLoggingHandler.php` | Monolog 3 changes affect handler record types and levels. |
| Excel exports | `app/Exports/*`, panel controllers | Verify `maatwebsite/excel` compatibility and facade alias behavior. |
| Images | Upload controllers, `config/image.php`, `config/app.php` | Verify Intervention major-version API and Laravel package support. |
| Frontend build | `package.json`, `webpack.mix.js` | Defer Mix/Vite migration unless Composer or Laravel asset helper changes force it. |

## First Composer Dry-Run Target

Start with the Laravel 9 dependency set only:

```bash
composer remove fideloper/proxy fruitcake/laravel-cors --no-update
composer remove facade/ignition --dev --no-update
composer require php:^8.0.2 laravel/framework:^9.0 --no-update
composer require spatie/laravel-ignition:^1.0 nunomaduro/collision:^6.1 --dev --no-update
composer update --dry-run
```

If Composer reports package conflicts, prefer resolving third-party package constraints before changing application code.
