
# Deploying Participes App in a LAMP environment

The app is built with Laravel 8.x and uses an InnoDB database that I would recommend **MySQL 5.6+ or MariaDB**.

Under the assumption that we have a Ubuntu 18.04 LTS based virtual machine as a server.

Resources: 
* [Laravel 8.x - Installation](https://laravel.com/docs/8.x/installation)
* [Laravel 8.x - Configuration](https://laravel.com/docs/8.x/configuration)
* [Laravel 8.x - Deployment](https://laravel.com/docs/8.x/deployment)

Notes: We focused this manual in the installation of the application for a LAMP environment. Regarding Server or Webserver configurations, it is up to the deployment team.

> **The Docker version of the app is not ready yet. We will update this document when it is ready. If you want to help us with this, please fork the repo and make a Pull Request, it will be very appreciated.**

##### Before starting...

Laravel requiere **PHP >= 7.3**. No es muy diferente a lo que seria un deployment de Symfony u otros frameworks de PHP. En `production`, deberian ir por un **PHP-FPM** por razones de performance.


#### Requisitos:

1. **PHP >= 7.3.x** y **PHP-FPM** (Recomendado para produccion). (It is confirmed it works with PHP 7.4.x)
2. A webserver, like **Apache** o **Nginx** thatr points to the project's `/public` directory. (Doc para [nginx](https://laravel.com/docs/7.x/deployment#nginx))
3. **MySQL 5.6+ o MariaDB** as the database engine.
4. **Composer** [https://getcomposer.org/](https://getcomposer.org/) for installing the project's dependencies
5. **REDIS** [https://redis.io/](https://redis.io/), "an advanced key-value store" used in parallel with the database to queue Laravel Jobs, important for enabling email and platform notifications
6. **SUPERVISOR** [http://supervisord.org/](http://supervisord.org/), "a process control system" that controls and monitors processes. Important for running Laravel's Queue listeners.
7. A **SMTP** email to send mails. The configuration can be found in the `.env` file.
8. A **Google reCAPTCHA v2** [https://www.google.com/recaptcha](https://www.google.com/recaptcha) to prevent spam. Since we use Google reCaptcha, it is also important that you create a reCaptcha for the site and that in the environment variables enter the values for `NOCAPTCHA_SECRET` and `NOCAPTCHA_SITEKEY`. More information at [Google Recaptcha](https://www.google.com/recaptcha/)
9. (Optional) A **Mapbox** [https://mapbox.com](https://mapbox.com) to consume map tiles.
10. (Optional) A **Google Analytics 4** [https://analytics.google.com](https://analytics.google.com) to track the platform's usage.

##### About MAPBOX

The use of maps can be configured in the admin panel. It is up to the team to decide if to enable georeference or not. If you decide to enable it, you will need to create an account in [Mapbox](https://mapbox.com) and get the API Token.


1. Go to [https://mapbox.com](https://mapbox.com)
2. Create an account
3. Log in, and in the dashboard, click on "Create a token"
4. Give the token a name and leave the following Token Scope checked:

```
Public scopes
Styles:tiles
Styles:read
Fonts:read
Datasets:read
Vision:read
```
5. In token restrictions you should restrict the use under a URL.

> IMPORTANT: Check the Mapbox pricing, it has a free tier that should be enough for the use you give to the platform, but be aware of it.

##### Con respecto a PHP

The app requires the following PHP extensions:

* BCMath PHP Extension
* Ctype PHP Extension
* Fileinfo PHP extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

Also, the application requires the following module to process images:

* Imagemagick PHP Extension

The folowing extensions are required to work for [Laravel Excel](https://laravel-excel.com/):

* PHP extension php_zip enabled `sudo apt-get install php-zip`
* PHP extension php_xml enabled `sudo apt-get install php-xml`
* PHP extension php_gd2 enabled `sudo apt-get install php-gd`
* PHP extension php_iconv enabled 0
* PHP extension php_simplexml enabled
* PHP extension php_xmlreader enabled
* PHP extension php_zlib enabled

If the instalaion running `$ composer install` returns an error, it is probably due to a missing extension. Please pay attention to the error messages.


##### PHP FPM Install dependencies & configurations

This is an example of a deployment I made and some configurations for PHP. I am not sure if all of them are needed, but I will leave them here for reference.

```bash
ubuntu:~$ sudo apt install php-fpm php-mysql
ubuntu:~$ sudo apt install php-mbstring php-xml php-bcmath 
# El siguiente puede fallar... por lo menos php imagick php-zip y 
# php-gd es requerido para una de las dependencias. Cualquier cosa composer install va a decir que falta...
ubuntu:~$ sudo apt install php-imagick php-zip php-iconv php-simplexml php-xmlreader php-zlib php-gd 
```

Now we need to configure PHP. We will edit the `/etc/php/7.4/fpm/php.ini` file.

```bash
ubuntu:/etc/php/7.4/fpm# nano php.ini
```

We will change the following `upload_max_filesize` and `post_max_size` values:

```
upload_max_filesize = 2M ==> upload_max_filesize = 100M
post_max_size = 8M ==> post_max_size = 128M

# Los siguiente no los termine agregando, me interesaba los de arriba...
memory_limit = 128M ==> memory_limit = 1024M
max_execution_time = 30 ==> max_execution_time = 300
```

Now we restart the services.

```
ubuntu:/etc/php/7.4/fpm# systemctl restart php7.4-fpm
ubuntu:/etc/php/7.4/fpm# sudo systemctl restart nginx
```

##### Redis

Redis is a key-value store that is used by Laravel to queue jobs. It is important to install it before installing the application.

We will use the apt package manager to install Redis. We will use the apt package cache and then install Redis.

```
sudo apt update
sudo apt install redis-server
```

This will download and install Redis and its dependencies. Following this, there is an important configuration to make in the Redis configuration file, which is automatically generated during installation.

Open the Redis configuration file with the following command:

```
sudo nano /etc/redis/redis.conf
```

Inside the file, you will find the "supervised directive". The directive allows you to declare an init system to manage Redis as a service, providing more control over its operation. The supervised directive is declared as NO by default. Since we are running on Ubuntu (hopefully...), which uses the systemd init system, we change this to systemd:

```
. . .

# If you run Redis from upstart or systemd, Redis can interact with your
# supervision tree. Options:
#   supervised no      - no supervision interaction
#   supervised upstart - signal upstart by putting Redis into SIGSTOP mode
#   supervised systemd - signal systemd by writing READY=1 to $NOTIFY_SOCKET
#   supervised auto    - detect upstart or systemd method based on
#                        UPSTART_JOB or NOTIFY_SOCKET environment variables
# Note: these supervision methods only signal "process is ready."
#       They do not enable continuous liveness pings back to your supervisor.
supervised systemd

. . .
```

This is the only change we need to make in the Redis configuration file. So, we save and close the editor once done. Then, we need to restart the Redis service to reflect the changes made in the configuration file:

```
sudo systemctl restart redis.service
```

Whit this, Redis should be installed and configured. Before continuing, it would be good to test Redis.

Lets check if Redis is running:

```
sudo systemctl status redis
```

If it is running without any errors, this command will produce an output similar to the following:

```
Output
● redis-server.service - Advanced key-value store
   Loaded: loaded (/lib/systemd/system/redis-server.service; enabled; vendor preset: enabled)
   Active: active (running) since Wed 2018-06-27 18:48:52 UTC; 12s ago
     Docs: http://redis.io/documentation,
           man:redis-server(1)
  Process: 2421 ExecStop=/bin/kill -s TERM $MAINPID (code=exited, status=0/SUCCESS)
  Process: 2424 ExecStart=/usr/bin/redis-server /etc/redis/redis.conf (code=exited, status=0/SUCCESS)
 Main PID: 2445 (redis-server)
    Tasks: 4 (limit: 4704)
   CGroup: /system.slice/redis-server.service
           └─2445 /usr/bin/redis-server 127.0.0.1:6379
. . .
```

Here you can see that Redis is running and is enabled, which means it is configured to start on every server boot.

To test that Redis is working correctly, connect to the server using the command line client:

```bash
redis-cli
```

In the CLI test the connectivity with the following command:

```bash
> ping
Output
PONG
```

##### Supervisor (Part 1)

Supervisor is a client/server system that allows its users to monitor and control a number of processes on UNIX-like operating systems. Supervisor is used to manage the queue workers and the scheduler.

Install Supervisor with the following command:

```
sudo apt install supervisor
```

This will download and install Supervisor and its dependencies. Following this, there is an important configuration to make in the Supervisor configuration file, which is automatically generated during installation.

The prebuild comes with a script that requires the OS to restart, but we can force the restart of supervisor by doing

```
sudo service supervisor restart
```

Now supervisor is installed. We will continue with the install later after installing the application.

##### Nginx

Nginx is a web server that will serve the application. We will use the apt package manager to install Nginx. We will use the apt package cache and then install Nginx.

```
sudo apt update
sudo apt install nginx
```

Now we disable the default site and enable the participes site.

```
sudo unlink /etc/nginx/sites-enabled/default
```

To check for errors, try:

```bash
sudo nginx -t
```

Other commands to have in mind:

```bash
# Reload nxing changes in sites.
sudo systemctl reload nginx

# Restart nginx (it also reloads the configuration)
sudo systemctl restart nginx

# Check the status of nginx
sudo systemctl status nginx
```

According to the official documentation for Laravel 8:

*"If you are deploying your application to a server that is running Nginx, you may use the following configuration file as a starting point for configuring your web server. Most likely, this file will need to be customized depending on your server's configuration."*

**NOTE**: This configuration assumes you have php-fpm. If you are using php-cgi, you will need to make some changes to the configuration file.

**NOTE 2**: This configuration also is for port 80. If you are using HTTPS, you will need to make some changes to the configuration file. Usually using `certbot` takes this configuration and creates a new one for you but for port 443 (HTTPS) and it edits this file to redirect all HTTP traffic to HTTPS.

We will create a new file in the `/etc/nginx/sites-available` folder.

```bash
democracyos@sumen2021:/etc/nginx/sites-available$ sudo nano sumen.conf
```

```nginx
server {
    listen 80;
    server_name participes.org;
    access_log /var/log/nginx/access_https.log;
    error_log /var/log/nginx/error_https.log;
    root /var/www/participes-app/public;
 
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";
 
    index index.php;
 
    charset utf-8;
 
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
 
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
 
    error_page 404 /index.php;
 
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
 
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Now enable the site and restart nginx.

```
sudo ln -s /etc/nginx/sites-available/participes /etc/nginx/sites-enabled/
sudo systemctl restart nginx
```

Now you can run certbot to enable SSL in your server.

```
sudo certbot --nginx
```

## Installing participes

Clone the repository 

```
ubuntu:~$ cd /var/www
ubuntu:/var/www$ git clone https://github.com/DemocraciaEnRed/participes-app.git
```

Later inside the root folder of the project we will do a git pull (just in case) and install the dependencies.

```bash
ubuntu:/var/www$ cd participes-app
ubuntu:/var/www/participes-app$ git pull
ubuntu:/var/www/participes-app$ composer dump-autoload -o
ubuntu:/var/www/participes-app$ composer install
```

##### Environment variables

Copy the `.env.example` file and rename it to `.env`

```bash
ubuntu:/var/www/participes-app$ cp .env.example .env
ubuntu:/var/www/participes-app$ nano .env
```

Have in count that the values #####COMPLETAR###### are important. Any problem with the Laravel documentation you can find more information: [Laravel 8 - Configuration - Environment Configuration](https://laravel.com/docs/8.x/configuration#environment-configuration)

> **NOTE**: APP_ENV=local and APP_DEBUG=false are the development states, for now let's leave it like that, until we verify that the platform is working and it can be changed for a production environment to APP_ENV=production and APP_DEBUG=false (APP_DEBUG=false enables the Laravel Debugbar to see some logs)

`.env`

```
APP_NAME=Participes App
APP_ENV=local
APP_KEY=#####VER-ARTISAN-KEY:GENERATE######
APP_DEBUG=false
APP_URL=#####COMPLETAR######

NOCAPTCHA_SECRET=#####COMPLETAR######
NOCAPTCHA_SITEKEY=#####COMPLETAR######

DB_SPECIFIED_KEY_FIX=false

FORCE_HTTPS=false

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=#####COMPLETAR######
DB_USERNAME=#####COMPLETAR######
DB_PASSWORD=#####COMPLETAR######

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=redis
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_QUEUE=mailer,default

# Mailer.. si se usa mailgun, agregar lo siguiente
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=#####COMPLETAR######
MAILGUN_SECRET=#####COMPLETAR######

# ENVs para Mailer
MAIL_HOST=#####COMPLETAR######
MAIL_PORT=#####COMPLETAR######
MAIL_USERNAME=#####COMPLETAR######
MAIL_PASSWORD=#####COMPLETAR######
MAIL_ENCRYPTION=#####COMPLETAR######
MAIL_FROM_ADDRESS=#####COMPLETAR######
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

With `APP_ENV=local` we can access the `/start` route from the browser to make the admin user. (In production we have to change to `APP_ENV=production`)

Let's generate the key for the application that will be added to the `.env` file automatically.

```bash
democracyos@sumen2021:/var/www/participes-app$ sudo php artisan key:generate
Application key set successfully.
```

Now we will do a symlink for the storage folder and the public folder.

```bash
democracyos@sumen2021:/var/www/participes-app$ sudo php artisan storage:link
The [/var/www/participes-app/public/storage] link has been connected to [/var/www/participes-app/storage/app/public].
The links have been created.
```

Now we will apply the needed permissions to the folders.

```bash
ubuntu:/var/www/participes-app$ sudo chown -R www-data:www-data /var/www/participes-app/vendor
ubuntu:/var/www/participes-app$ sudo chown -R www-data:www-data /var/www/participes-app/storage
```

Now we will create the database and the tables.

```bash
ubuntu:/var/www/participes-app$ sudo php artisan migrate:fresh --force
Dropped all tables successfully.
Migration table created successfully.
Migrating: 2020_06_22_000000_participes_start
Migrated:  2020_06_22_000000_participes_start (1.66 seconds)
```

#### Configuring Supervisor

We will configure Supervisor to manage the processes that take the queued emails and send them.

Lets create the config files for the processes.

`ubuntu:/etc/supervisor/conf.d# nano sumen-database.conf`

```bash
[program:sumen-database]
command=php artisan queue:work redis --queue=database
redirect_stderr=true
autostart=true
autorestart=true
user=root
numprocs=1
directory=/var/www/participes-app/
process_name=%(program_name)s_%(process_num)s
stderr_logfile=/var/log/participes-database.err.log
stdout_logfile=/var/log/participes-database.out.log
```

`ubuntu:/etc/supervisor/conf.d# nano sumen-mailer.conf`

```
[program:sumen-mailer]
command=php artisan queue:work redis --queue=mailer
redirect_stderr=true
autostart=true
autorestart=true
user=root
numprocs=1
directory=/var/www/participes-app/
process_name=%(program_name)s_%(process_num)s
stderr_logfile=/var/log/participes-mailer.err.log
stdout_logfile=/var/log/participes-mailer.out.log
```

Next we will update the supervisor configuration. RUNNING means that they are running. With the `supervisorctl` command you can see the status. Technically it is programmed so that if you restart the server supervisorctl works.

```bash
ubuntu:/etc/supervisor/conf.d# supervisorctl reread
participes-database: available
participes-mailer: available

ubuntu:/etc/supervisor/conf.d# supervisorctl update
participes-database: added process group
participes-mailer: added process group

ubuntu:/etc/supervisor/conf.d# supervisorctl
participes-database:participes-database_0   RUNNING   pid 293547, uptime 0:00:20
participes-mailer:participes-mailer_0       RUNNING   pid 293548, uptime 0:00:20
>
```
#### Last steps

Now we will create the admin user. We will access the `/start` route from the browser having APP_ENV=local in the `.env` file.

After creating the admin user we will change the `APP_ENV=production` to production.

Make sure `APP_DEBUG=false` in the `.env` file for production.

Now we apply optimizations
```
ubuntu:/var/www/participes-app# composer dump-autoload -o
Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi
Discovered Package: anhskohbo/no-captcha
Discovered Package: barryvdh/laravel-debugbar
Discovered Package: facade/ignition
Discovered Package: fideloper/proxy
Discovered Package: fruitcake/laravel-cors
Discovered Package: intervention/image
Discovered Package: laravel/tinker
Discovered Package: laravel/ui
Discovered Package: maatwebsite/excel
Discovered Package: nesbot/carbon
Discovered Package: nunomaduro/collision
Package manifest generated successfully.
Generated optimized autoload files containing 5454 classes

ubuntu:/var/www/participes-app# php artisan clear-compiled
Compiled services and packages files removed!

ubuntu:/var/www/participes-app# php artisan view:clear
Compiled views cleared!

ubuntu:/var/www/participes-app# php artisan config:clear
Configuration cache cleared!

ubuntu:/var/www/participes-app# php artisan optimize
Configuration cache cleared!
Configuration cached successfully!
Route cache cleared!
Routes cached successfully!
Files cached successfully!

ubuntu:/var/www/participes-app# php artisan queue:restart
Broadcasting queue restart signal.

ubuntu:/var/www/participes-app# supervisorctl

participes-database:participes-database_0   RUNNING   pid 295455, uptime 0:00:06
participes-mailer:participes-mailer_0       RUNNING   pid 295456, uptime 0:00:06
supervisor> 

ubuntu:/var/www/participes-app# 
```
#### Updating the application

Updating the application is as simple as pulling the changes from the repository and running the migrations. Always make sure to backup everything you need before updating (server, database, files, etc.)

1. First we do a pull of the repository (`git pull` or `git merge`)
2. We do a dump-autoload
3. We do a composer install
4. We do a migrate (in production mode the `--force` flag must be used)
2. We do cache cleaning. *"clear-compiled command is used to clear the compiled classes and services application cache. Basically, it clears the old boostrap/cache/compiled.php"*
3. We do view cache cleaning
4. We do configuration cache cleaning
5. Recreate boostrap/cache/compiled.php
6. Generate autoload
7. Restart the queues that handle the mails

```bash
git pull
composer dump-autoload -o
composer install
php artisan migrate --force
php artisan clear-compiled
php artisan view:clear
php artisan config:clear
php artisan optimize
composer dump-autoload -o
php artisan queue:restart
```
---

## Troubleshooting

#### config/app.php

Check your `php.ini` settings. You might want to check the file upload configurations and maybe the timezone settings.

In your app, by default the timezone is defined like this. Change it if you need to.

`'timezone' => 'America/Argentina/Buenos_Aires'`

#### DB_SPECIFIED_KEY_FIX=false

If you are getting the following exception when running php artisan migration -force
```
[Illuminate\Database\QueryException]
SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes (SQL: alter table users add unique users_email_unique(email))

[PDOException]
SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes
```

Then you might try to enable `DB_SPECIFIED_KEY_FIX=true` and try again

If that doesnt work.. Maybe you might need to enable InnoDB `ROW_FORMAT=DYNAMIC` in MariaDB..

Some useful resources:

- https://webomnizz.com/how-to-fix-laravel-specified-key-was-too-long-error/
- https://github.com/laravel/framework/issues/17508
- https://mariadb.com/kb/en/innodb-dynamic-row-format/

#### Error: Mixed content API

This problem is related to the fact that the API is served over HTTP and the app over HTTPS. Sometimes the browser will block the request because of the mixed content. It's OK to deploy the app over HTTP, if you have a proxy that serves the app over HTTPS.

If you are using Cloudflare which serves the app over HTTPS, you may have problems with the API response. One way to fix the error of Mixed Content API is to force the app to use HTTPS.

For that, you can set up in the `.env` file the variable `FORCE_HTTPS` to `true`. In the `boot()` function of `/app/Providers/AppServiceProvider.php` there is a condition that will force the app to use HTTPS.


```php

    public function boot()
    {
        if(config('app.force_https')){
            URL::forceScheme('https');
        }

        // ...
    }
```

##### Configuring Trusted Proxies

When running your applications behind a load balancer that terminates TLS / SSL certificates, you may notice your application sometimes does not generate HTTPS links. Typically this is because your application is being forwarded traffic from your load balancer on port 80 and does not know it should generate secure links.

To solve this, you may use the `App\Http\Middleware\TrustProxies` middleware that is included in your Laravel application, which allows you to quickly customize the load balancers or proxies that should be trusted by your application. Your trusted proxies should be listed as an array on the `$proxies` property of this middleware. In addition to configuring the trusted proxies, you may configure the proxy `$headers` that should be trusted:

```php
namespace App\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var string|array
     */
    protected $proxies = [
        '192.168.1.1',
        '192.168.1.2',
    ];

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
```
> If you are using AWS Elastic Load Balancing, your `$headers` value should be `Request::HEADER_X_FORWARDED_AWS_ELB`. For more information on the constants that may be used in the `$headers `property, check out Laravel's documentation on trusting proxies.

#### Trusting All Proxies

If you are using Amazon AWS or another "cloud" load balancer provider, you may not know the IP addresses of your actual balancers. In this case, you may use * to trust all proxies:

```php
namespace App\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var string|array
     */
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
```

---

> The following are general tips for deploying Laravel applications. Thank you ChatGPT!

## Deploying in a LAMP Server

Here is a step-by-step guide to deploy a Laravel 8 application on a LAMP server:

* Install LAMP (Linux, Apache, MySQL, PHP) on your server if it is not already installed.
* Create a new database for your Laravel application in MySQL.
* Download the Laravel 8 application on your server.
* Configure the Apache virtual host to point to the Laravel 8 application's public directory.
* Update the database credentials in the .env file in your Laravel application.
* Run the following commands in your Laravel application directory to install dependencies and optimize the application:
```
composer install
php artisan optimize
```

* Set the proper permissions for the storage and bootstrap/cache directories.
* Restart the Apache service to apply the changes.
* Access your Laravel application through a web browser to verify that it is working properly.

This is a basic guide to deploy Laravel 8 on a LAMP server. Please note that some additional steps might be required based on your specific requirements and setup.


### Using php-fpm

PHP-FPM is a FastCGI process manager for PHP. It is a more efficient alternative to the traditional PHP-CGI, which is used by default in Apache.

It's recommended to use php-fpm in production environments, as it is more efficient and can handle more concurrent requests.

Here is a step-by-step guide to set up php-fpm in Apache on an Ubuntu server:

* Install php-fpm:

```sql
sudo apt-get update
sudo apt-get install php-fpm
```

* Configure php-fpm:

```bash
sudo nano /etc/php/7.4/fpm/php.ini
```

* Make sure that the following line is uncommented:
```
cgi.fix_pathinfo=0
```
* Save and close the file.

* Configure the Apache virtual host to use php-fpm:

```bash
sudo nano /etc/apache2/sites-available/example.com.conf
```

* Add the following lines to the virtual host configuration:

```perl

<FilesMatch ".+\.php$">
   SetHandler "proxy:unix:/var/run/php/php7.4-fpm.sock|fcgi://localhost"
</FilesMatch>
```

* Save and close the file.

* Enable the virtual host:
```bash
sudo a2ensite example.com.conf
```
* Restart Apache:
```bash
sudo service apache2 restart
```
* Restart php-fpm:
```bash
sudo service php7.4-fpm restart
```
This is a basic guide to set up php-fpm in Apache on an Ubuntu server. Please note that some additional steps might be required based on your specific requirements and setup.

### Optimizing php-fpm

This are general tips to optimize php-fpm:

* Use the latest version of php-fpm, as newer versions often include performance optimizations.
* Use a FastCGI cache, such as Nginx FastCGI cache or Varnish, to cache the output of dynamic PHP pages.
* Tune the pm settings in the /etc/php/7.4/fpm/pool.d/www.conf file:
  * `pm`: set it to dynamic mode, which automatically adjusts the number of worker processes based on the server's load.
  * `pm.max_children`: set it to a value that is appropriate for your server's memory and CPU capacity.
  * `pm.start_servers`: set it to a value that is appropriate for your server's capacity.
  * `pm.min_spare_servers`: set it to a value that is appropriate for your server's capacity.
  * `pm.max_spare_servers`: set it to a value that is appropriate for your server's capacity.
* Use a real-time monitor, such as New Relic, to monitor the performance of php-fpm and identify performance bottlenecks.
* Use a process manager, such as Supervisor, to manage the php-fpm process and restart it automatically if it crashes.

These are general tips to optimize php-fpm. The optimal settings for your server will depend on your specific requirements and setup. It is important to monitor your server's performance and adjust the settings as needed to ensure optimal performance.