# 2022-01-13
## Migration to Laravel 8

- Updating Laravel 7 to Laravel 8
- Note: Minimum PHP version is now 7.3+

Following the [Laravel 8 Upgrade Guide](https://laravel.com/docs/8.x/upgrade)

#### Removing ipunkt/laravel-analytics

- The package is not compatible with Laravel 8 and the package is not maintained anymore
- Deleted config/analytics.php (No longer required)
- Removed the Provider from config/app.php

We manually added the js code to the view and its available by activating it on the admin panel.
