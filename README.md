# Participes



## Changelog

#### 2023-01-18

* The env vars `ANALYTICS_PROVIDER`, `ANALYTICS_PROVIDER`, `ANALYTICS_TRACKING_ID` are no longer required in the .env file. From now on you can use the admin panel to set up Google Analytics 4 by inserting the tracking ID.
* Participes has been updated to Laravel 8. It requires PHP 7.4 or higher.
* New migrations are being added for the new Laravel version. If you installed Participes before 2023, you should run the new migrations. You can do this by running `php artisan migrate` in the root directory of the project. In production you should run `php artisan migrate --force` to avoid any errors.
* As always, we recommend you to make a backup of your database before running the migrations.
* Removed fzaninotto/faker dependency for the sake of Laravel 8. Faker 


## Start developing

First, make sure you have instaled:

- PHP +7.4
- Imagemagick
- MySQL
- Node + NPM (For local development and building)

You can use phpbrew to install PHP and composer to install the dependencies.
```
phpbrew install 7.3 +default +mysql
phpbrew use 7.3
phpbrew ext install gd
phpbrew ext install imagick
```

Clone the Repo.

Open a terminal in the root of the project:

```
$ composer install
```

With the `$ composer install` a `.env` file should've been created. 

> From [Laravel Docs](https://laravel.com/docs/7.x/installation): If you installed Laravel via Composer or the Laravel installer, this key has already been set for you by the `php artisan key:generate command`.(...) If the application key is not set, your user sessions and other encrypted data will not be secure!

So Look and configure the following env variables (others vars, dont worry) 

```

APP_NAME=Partícipes
APP_ENV=local
APP_KEY= # Run php artisan key:generate and use the output!
APP_DEBUG=true
APP_URL=http://localhost

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

QUEUE_CONNECTION=sync

NOCAPTCHA_SECRET=
NOCAPTCHA_SITEKEY=

MAPBOX_API_KEY=
MAPBOX_MAP_STYLE=mapbox://styles/mapbox/light-v10
```

Now create a new MySQL database. You can create a `participes` mysql database, if you want to use another name, change it in `DB_DATABASE`. It should be `'charset' => 'utf8mb4' // 'collation' => 'utf8mb4_unicode_ci'`

Now run the first migration. Its the init DB.

```
php artisan migration
php artisan db:seed
```

Your tables should've been created with demo data.

Now you can enter with:
```
User: admin@admin.com
Pass: participes
```

## Little Consideration

#### config/app.php
Check your `php.ini` settings. You might want to check the file upload configurations and maybe the timezone settings.

In your app, by default the timezone is defined like this. Change it if you need to.

```
'timezone' => 'America/Argentina/Buenos_Aires',
```

#### Available roles

**Role: user**

By default, any new registered user gets the `user` role

**Role: admin**

Those who want to manage the platform should have the `admin` role, which gives them access to a few views and other things.
These should be managed manually. An admin should be able to add other admins.

Just to clarify: We follow this philosophy:
**Admins are not human entities: They are one, and many at the same time. They share the same decisions. They work together. They have concensum. They dont make mistakes.**

With this in mind, we give answers to a few questions:

- *Can an admin delete other admins?* Yes.
- *Can an admin delete content other admins created?* Yes.

They are amazing, right?

## Using REDIS as queue manager

Imagine sending 50 new report emails to subscriptors in one process... it will take like a minute or more for the process to contact the SMTP and it will block the user experience, stuck in the same page, for a minute or more. If we dont want this on production, we need to set up Queues and Workers.

> **NOTE**: If you still want to be blocked by this jobs, you can just use the `sync` option in the `QUEUE_CONNECTION` in the `.env` file like this: `QUEUE_CONNECTION=sync`

In production, we will need to use a complementary service called Redis for queueing jobs. This will accelerate async jobs like mailing and other stuff.

> Why use Redis for your Laravel queue connection? Redis offers clustering and rate limiting. Let’s look at an example of rate limiting and why that might be important. - [https://voltagead.com/the-basics-of-laravel-queues-using-redis-and-horizon/](https://voltagead.com/the-basics-of-laravel-queues-using-redis-and-horizon/)

For development, we need to have REDIS installed. So you should have redis installed locally or just use a docker container.

```
$ docker run -d --name redis -p 6379:6379 redis
```

Useful docker redis commands:
```
$ docker start redis

$ docker stop redis
```

Now in .env, use this env variables:
```
# QUEUE_CONNECTION=sync -- we dont need this
QUEUE_CONNECTION=redis
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_QUEUE=mailer,default
```

Now in another terminal, run the following in the root directory:

```
$ php artisan queue:work redis --queue=mailer,default
```

Here, one process will work both queues at the same time.
If you prefer to have two different processes for each job queue, you can open two terminal and do: 

```
// Terminal 1
$ php artisan queue:work redis --queue=mailer
```
```
// Terminal 2
$ php artisan queue:work redis --queue=default
```

## Files - Storage Link

Run the following command

```
php artisan storage:link
```

## Run PHP Server

```
php artisan server:run
```


## Build JS and CSS

We are using Mix by Laravel to build the javascript and the css of the app.

Start by doing 

```
$ npm install
```

Now if you are going to make changes in the `.scss`, `.vue` or `.js` files and build the js in "real time", you will have to do:

```
$ npm run watch
```

If you just want to build in development mode, use: 
```
$ npm run development
```

If you want to build the files for production, run:

```
$ npm run production
```
