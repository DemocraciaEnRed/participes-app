# AGENTS

This repository is a Laravel 8 application with a Vue 2 frontend.

## Runtime Rules

- Use `php7.4` for Laravel and Composer commands in this environment.
- Run `nvm use` in the repo root before any frontend or asset command. The project pins Node with [.nvmrc](.nvmrc).
- Keep `sass` pinned to `1.57.1`. Upgrading it can pull a Node 20 requirement that does not match the pinned Node 18 runtime.

## Common Commands

- Install PHP dependencies: `php7.4 $(which composer) install`
- Install JS dependencies: `nvm use && npm install`
- Generate app key: `php7.4 artisan key:generate`
- Run migrations: `php7.4 artisan migrate`
- Seed demo data: `php7.4 artisan db:seed`
- Run tests: `php7.4 vendor/bin/phpunit`
- Dev build: `nvm use && npm run development`
- Watch assets: `nvm use && npm run watch`
- Production build: `nvm use && npm run production`

## Project Shape

- Web routes live in [routes/web.php](routes/web.php); API routes live in [routes/api.php](routes/api.php).
- Domain logic is centered in Eloquent models under [app](app) with observers, policies, middleware, and exports alongside them.
- Frontend assets have two entry points:
  - Public app: [resources/js/app.js](resources/js/app.js)
  - Admin app: [resources/js/admin-app.js](resources/js/admin-app.js)
- Asset compilation is defined in [webpack.mix.js](webpack.mix.js) and outputs to [public/js](public/js) and [public/css](public/css).
- Blade views live under [resources/views](resources/views).

## Repository-Specific Conventions

- Vue components are registered manually in the JS entry points. There is no active auto-discovery pattern.
- Custom Blade directives and conditionals are registered in [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php). Check this before changing auth or date rendering behavior.
- Role and membership checks use custom Blade helpers such as `@isMember`, `@isManager`, `@isReporter`, and their `Only` variants.
- Shared PHP helpers are autoloaded from [app/Util/helpers.php](app/Util/helpers.php).
- Settings can be driven from the database and cached, so config changes may require `php7.4 artisan cache:clear`.

## Working Guidance

- Prefer focused changes that match existing Laravel 8 and Vue 2 patterns.
- Do not modernize framework or frontend tooling unless the task explicitly asks for it.
- When touching frontend code, verify whether the change belongs in the public app entrypoint, the admin app entrypoint, or both.
- When changing role-gated UI in Blade, confirm the matching directive semantics in [FRONTEND.md](FRONTEND.md) and [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php).

## Existing Docs

- Setup and local development: [README.md](README.md)
- Frontend and Blade conventions: [FRONTEND.md](FRONTEND.md)
- Deployment details: [DEPLOY.md](DEPLOY.md)
- Migration notes: [MIGRATION.md](MIGRATION.md)