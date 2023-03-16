# Participes

Plataforma digital para gobiernos e instituciones que permite la publicación de metas y compromisos, facilitando el seguimiento de avances y la transparencia activa.

![image](https://user-images.githubusercontent.com/8771166/215751657-244b7d63-0345-4432-900d-d7843795e3e5.png)

## Changelog

### v2.3.1 (2023-03-16)
* Fixed paginator not using Bootstrap 5 classes.
* Now the tags of a objective, if the list is empty, it wont show the "Tags" title neither a "No hay tags" message.

### v2.3.1 (2023-02-03)
* Fixed a bug in "Objetivos" view.

### (2023-02-03)
* No new version. Just a small fix in the README.md file.
* Added DEPLOY.md file with instructions to deploy the project in a LAMP server.

### v2.3 (2023-02-01)

* There is a new migration with this version, make sure to run it. You can do this by running `php artisan migrate` in the root directory of the project. In production you should run `php artisan migrate --force` to avoid any errors.
* As always, we recommend you to make a backup of your database before running the migrations.
* Fixed some bugs with the admin panel for maps (nothing critical)
* New "homepage" admin panel. Now you have in one place all the customizations you can do to the homepage. Inside we included a few ones:
  * You can show/hide the latest published reports
  * You can show/hide the graph of reports published in the last 15 days
  * You can "move" the latest published reports after the "latest objectives updated"
  * You can show/hide the categories selector.
  * Moved the "subtitle" of the homepage to the admin panel
* New "SEO & Analytics" admin panel. Nothing new, but all the cusotmizations you can do to the SEO and Analytics are now in one place.
* Fixed "Limpiar cache" button in the admin panel. Now it works as expected.
* Fixed some "boolean" casts in the Settings model.
* New component "Category selector" which is a carrousel component of the categories of the system. When you click in a category, it takes you to the catalog of objectives.
* Some changes in some views:
  * In the objective view, if the following attributes are empty, they wont be shown: "Miembros del equipo", "Organizciones", "Metas"
  * In the goal view, if the following attributes are empty, they wont be shown: "Hitos"
* Some secondary fixes (Demo data had a bug when creating generic organizations)


### v2.2 (2023-02-01)

* No migrations in this version
* Major update in mapbox GL JS from 1.11.1 to 2.4.1, with this update we are able to use the new mapbox styles and the new mapbox studio.
* Updated mapbox-gl-draw plugin from 1.0.9 to 1.4.0.
* NOTE: You should use the Style URL mapbox://styles/mapbox/light-v11 instead of the old style url mapbox://styles/mapbox/light-v10
* Fixed some maps not getting the Mapbox API Key

### v2.1 (2023-02-01)

* There is a new migration with this version, make sure to run it. You can do this by running `php artisan migrate` in the root directory of the project. In production you should run `php artisan migrate --force` to avoid any errors.
* As always, we recommend you to make a backup of your database before running the migrations.
* Added Map & Georeference admin to the admin panel. Now instead of setting the map and georeference in the .env file, you can do it in the admin panel.
* The env vars `MAPBOX_API_KEY` & `MAPBOX_MAP_STYLE` are no longer required in the .env file. If you are planning to update to this version, make sure that after the update you set the api key and map style in the admin panel.
* You can also hide the map from the homepage
* If maps & georeference are disabled, the map will not be shown in the homepage and reports wont have a map. The report panel also wont show the "Map" option in the menu.

#### v2.0 (2023-01-18)

* New migrations are being added for the new Laravel version. If you installed Participes before 2023, you should run the new migrations. You can do this by running `php artisan migrate` in the root directory of the project. In production you should run `php artisan migrate --force` to avoid any errors.
* As always, we recommend you to make a backup of your database before running the migrations.
* Participes has been updated to Laravel 8. It requires PHP 7.4 or higher.
* The env vars `ANALYTICS_PROVIDER`, `ANALYTICS_PROVIDER`, `ANALYTICS_TRACKING_ID` are no longer required in the .env file. From now on you can use the admin panel to set up Google Analytics 4 by inserting the tracking ID.
* Removed fzaninotto/faker dependency for the sake of Laravel 8. Faker 


## Deployment instructions 

Please check out [DEPLOY.md](DEPLOY.md) file

---

## Development

First, make sure you have instaled:

- PHP +7.4
- Imagemagick
- MySQL
- Node + NPM (For local development and building)

You can use phpbrew to install PHP and composer to install the dependencies.
```
phpbrew install 7.4 +default +mysql
phpbrew use 7.4
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
