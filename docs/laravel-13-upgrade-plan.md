# Laravel 13 Upgrade Plan

This plan is for upgrading Participes from Laravel 8 to Laravel 13 using the local guides in `migration-guides/`.

## Current Baseline

- Current framework: `laravel/framework:^8.0`.
- Current PHP constraint: `^7.3|^8.0`.
- Frontend build: Laravel Mix 5, Webpack, Vue 2.7, Bootstrap 4.
- Branch: `upgrade/laravel-13.x`.
- Existing migration notes: `MIGRATION.md` documents the previous Laravel 7 to 8 upgrade.

## Strategy

Upgrade one Laravel major at a time and keep each step independently testable:

1. Laravel 8 to 9.
2. Laravel 9 to 10.
3. Laravel 10 to 11.
4. Laravel 11 to 12.
5. Laravel 12 to 13.

Do not migrate to the Laravel 11+ slim application structure during this upgrade. Laravel 11 supports the older application structure, and preserving it reduces risk.

## Operating Rules

- Each major version gets its own checkpoint commit after tests pass.
- Only apply changes required for the current major version.
- Do not combine frontend modernization with backend framework upgrades unless a package conflict forces it.
- Use `composer update --dry-run` before applying each dependency jump.
- Keep `composer.lock` changes reviewed carefully at each stage.
- Run the same validation suite after every major jump.

## Validation Gate For Every Major Step

Minimum gate:

```bash
composer validate
php artisan about
php artisan config:clear
php artisan route:list
php artisan test
npm run prod
```

Manual smoke gate:

- Login and logout.
- Public home page.
- Objective list and objective detail.
- Goal detail.
- Report creation, edit, delete, and comment flows.
- Admin settings, homepage settings, SEO / analytics settings.
- Excel exports.
- Image uploads and resizing.
- Mapbox map display and report georeference flow.
- Queue-backed mail notifications with `QUEUE_CONNECTION=sync` and Redis.

## Phase 0: Inventory And Baseline

Goals:

- Confirm local PHP / Composer versions and extension availability.
- Confirm whether `composer.lock` is in sync before starting dependency work.
- Capture current production-like behavior in staging.
- Add or improve smoke tests around the high-value flows listed above.

Checks to run:

```bash
php -v
composer --version
composer validate
php artisan test
npm run prod
```

Known baseline risks:

- The README still references PHP 7.4 development setup.
- Current Laravel 13 target will require a much newer PHP runtime than this repo currently documents.
- The frontend stack is old but should be treated as a separate migration track if possible.

## Phase 1: Laravel 8 to 9

Guide: `migration-guides/upgrade-guide-8.x-to-9.md`.

Main dependency changes:

- Raise PHP to at least 8.0.2.
- `laravel/framework:^9.0`.
- `nunomaduro/collision:^6.1`.
- Replace `facade/ignition` with `spatie/laravel-ignition:^1.0`.

Repo-specific work:

- Replace `Fruitcake\Cors\HandleCors` in `app/Http/Kernel.php` with the framework CORS middleware supported by the target version.
- Review `fideloper/proxy`; modern Laravel uses framework proxy middleware support.
- Review Symfony Mailer impact on all notification and mail configuration.
- Review filesystem usage for Flysystem 3 behavior changes.
- Search for custom casts that must handle `null` values.

Validation focus:

- Mail notifications.
- Storage / uploads.
- CORS behavior for API routes.

## Phase 2: Laravel 9 to 10

Guide: `migration-guides/upgrade-guide-9.x-to-10.md`.

Main dependency changes:

- Raise PHP to at least 8.1.
- Require Composer 2.2+.
- `laravel/framework:^10.0`.
- `laravel/ui:^4.0` if it remains installed.
- `spatie/laravel-ignition:^2.0`.
- Consider `phpunit/phpunit:^10.0` and `nunomaduro/collision:^7.0` together.
- Remove `minimum-stability: dev` or set it to `stable`.

Repo-specific work:

- Convert model `$dates` properties to `$casts` in:
  - `app/ActionLog.php`
  - `app/Event.php`
  - `app/Milestone.php`
  - `app/Report.php`
- Review custom Monolog code in `app/Logging/` for Monolog 3 compatibility.
- Check any direct DB expression string casting. Current `DB::raw` usage looks normal, but keep it in the review checklist.
- Keep `$routeMiddleware` unless we intentionally rename it to `$middlewareAliases`; rename is optional for upgraded apps.

Validation focus:

- Logging to the `action_logs` table.
- Date serialization and filtering around events, milestones, reports, and action logs.
- Admin and panel exports.

## Phase 3: Laravel 10 to 11

Guide: `migration-guides/upgrade-guide-10.x-to-11.md`.

Main dependency changes:

- Raise PHP to at least 8.2.
- `laravel/framework:^11.0`.
- `nunomaduro/collision:^8.1`.

Repo-specific work:

- Preserve the Laravel 10-style application structure.
- Review migrations that use `change()` and ensure all modifiers are explicitly retained.
- Review password rehashing behavior; current user password column appears conventional unless proven otherwise.
- Review cache prefix behavior if Redis cache is used in production.
- Confirm SQLite is not part of CI or local tests below SQLite 3.26.

Validation focus:

- Full migration run on a disposable database.
- Login flow and password handling.
- Redis queue and cache behavior.

## Phase 4: Laravel 11 to 12

Guide: `migration-guides/upgrade-guide-11.x-to-12.md`.

Main dependency changes:

- `laravel/framework:^12.0`.
- `phpunit/phpunit:^11.0` if using PHPUnit.

Repo-specific work:

- Review Carbon 3 behavior in date comparisons and formatting.
- Search for `HasUuids` / `HasVersion7Uuids`; no current matches were found in the first scan.
- Review image validation behavior if SVG uploads are expected.
- Review `mergeIfMissing` usage; no current matches were found in the first scan.

Validation focus:

- Date-heavy public pages and reports.
- Image upload validation.
- Any code using schema table inspection.

## Phase 5: Laravel 12 to 13

Guide: `migration-guides/upgrade-guide-12.x-to-13.md`.

Main dependency changes:

- `laravel/framework:^13.0`.
- `laravel/tinker:^3.0`.
- `phpunit/phpunit:^12.0` if using PHPUnit.
- `laravel/boost:^2.0` is optional unless we decide to use Boost-assisted upgrade commands after reaching Laravel 12.

Repo-specific work:

- Review CSRF / request forgery protection changes from the guide.
- Explicitly set `CACHE_PREFIX`, `REDIS_PREFIX`, and `SESSION_COOKIE` in production env if preserving old generated names matters.
- Review whether the app stores PHP objects in cache. If yes, configure `cache.serializable_classes` explicitly or migrate cached payloads to arrays.
- Search for `upsert()` calls with empty `uniqueBy`; no current matches were found in the first scan.
- Review pagination Bootstrap view names if custom Bootstrap pagination views are used.

Validation focus:

- Sessions after deploy.
- Cache hit/miss behavior across deploy.
- CSRF-protected forms in admin and report panels.
- MySQL write paths and deletes.

## Package Risk Inventory

Backend packages to verify per major:

- `anhskohbo/no-captcha`
- `barryvdh/laravel-debugbar`
- `intervention/image`
- `laravel/ui`
- `maatwebsite/excel`
- `predis/predis`

Packages likely to remove or replace:

- `fideloper/proxy`
- `fruitcake/laravel-cors`
- `facade/ignition`

Frontend packages to defer unless blocked:

- `laravel-mix`
- `webpack` / Mix scripts
- `vue` and Vue 2 plugins
- `bootstrap` / `jquery` / `popper.js`
- Mapbox-related Vue packages

## Suggested Work Order

1. Run baseline validation and fix only blockers that prevent tests/build from running.
2. Create a dependency compatibility matrix for Composer packages.
3. Upgrade to Laravel 9 and resolve Composer conflicts first.
4. Fix Laravel 9 runtime issues.
5. Repeat for 10, 11, 12, and 13.
6. After Laravel 13 is stable, plan a separate frontend modernization track: Mix to Vite, then Vue 2 dependency risk review.

## Open Questions

- What PHP version will production use for the Laravel 13 deployment?
- Is there a staging database snapshot available for repeated migration testing?
- Is Redis used for cache, queues, sessions, or only queues?
- Are generated assets committed intentionally under `public/js` and `public/css`, or should the upgrade branch treat them as build outputs only?
- Is Laravel Shift or Laravel Boost acceptable as an optional assist at specific stages?
