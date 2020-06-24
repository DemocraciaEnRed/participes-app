# Participes

> In development.

## Start developing

Clone the Repo. Open a terminal in the root of the project:

```
$ composer install
```

With the `$ composer install` a `.env` file should've been created. 

> From [Laravel Docs](https://laravel.com/docs/7.x/installation): If you installed Laravel via Composer or the Laravel installer, this key has already been set for you by the `php artisan key:generate command`.(...) If the application key is not set, your user sessions and other encrypted data will not be secure!

So Look and configure the following env variables (others vars, dont worry) 

```
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=participes
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

Now create a new MySQL database. You can create a `participes` mysql database, if you want to use another name, change it in `DB_DATABASE`. It should be `'charset' => 'utf8mb4' // 'collation' => 'utf8mb4_unicode_ci'`

Now run the first migration. Its the init DB.

```
php artisan migration
php artisan db:seed
```

Your tables should've been created!

## Little Consideration

#### config/app.php

By default the timezone is defined like this. Change it if you need to.

```
'timezone' => 'America/Argentina/Buenos_Aires',
```