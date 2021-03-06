#!/usr/bin/env bash

set -e

if [ -f .env ]; then
   rm .env
fi

app_name=${APP_NAME:-example}
app_env=${APP_ENV:-app}
app_key=$(openssl rand -base64 32)
app_debug=${APP_DEBUG:-false}
app_url=${APP_URL:-http://localhost}
nocaptcha_secret=${NOCAPTCHA_SECRET}
nocaptcha_sitekey=${NOCAPTCHA_SITEKEY}
mapbox_api_key=${MAPBOX_API_KEY}
mapbox_map_style=${MAPBOX_MAP_STYLE}
log_channel=${LOG_CHANNEL:-stack}
db_connection=${DB_CONNECTION:-mysql}
db_host=${DB_HOST:-localhost}
db_port=${DB_PORT:-3306}
db_database=${DB_DATABASE:-laravel}
db_password=${DB_PASSWORD:-laravel}
broadcast_driver=${BROADCAST_DRIVER:-log}
cache_driver=${CACHE_DRIVER:-file}
queue_connection=${QUEUE_CONNECTION:-redis}
session_driver=${SESSION_DRIVER:-file}
session_lifetime=${SESSION_LIFETIME:-120}
redis_client=${REDIS_CLIENT:-predis}
redis_host=${REDIS_HOST:-localhost}
redis_password=${REDIS_PASSWORD}
redis_port=${REDIS_PORT:-6379}
redis_queue=${REDIS_QUEUE:-mailer,default}
mail_mailer=${MAIL_MAILER:-smtp}
mailgun_domain=${MAILGUN_DOMAIN}
mailgun_secret=${MAILGUN_SECRET}
mail_host=${MAIL_HOST:-localhost}
mail_port=${MAIL_PORT:-2525}
mail_username=${MAIL_USERNAME}
mail_password=${MAIL_PASSWORD}
mail_encryption=${MAIL_ENCRYPTION}
mail_from_address=${MAIL_FROM_ADDRESS}
mail_from_name=${MAIL_FROM_NAME}
aws_access_key_id=${AWS_ACCESS_KEY_ID}
aws_secret_key_id=${AWS_SECRET_KEY_ID}
aws_default_region=${AWS_DEFAULT_REGION}
aws_bucket=${AWS_BUCKET}
pusher_app_id=${PUSHER_APP_ID}
pusher_app_key=${PUSHER_APP_KEY}
pusher_app_secret=${PUSHER_APP_SECRET}
pusher_app_cluster=${PUSHER_APP_CLUSTER}
mix_pusher_app_key=${MIX_PUSHER_APP_KEY}
mix_pusher_app_cluster=${MIX_PUSHER_APP_CLUSTER}

echo "APP_NAME=$app_name" >> .env
echo "APP_ENV=$app_env" >> .env
echo "APP_KEY=base64:$app_key" >> .env
echo "APP_DEBUG=$app_debug" >> .env
echo "APP_URL=$app_url" >> .env
echo "NOCAPTCHA_SECRET=$nocaptcha_secret" >> .env
echo "NOCAPTCHA_SITEKEY=$nocaptcha_sitekey" >> .env
echo "MAPBOX_API_KEY=$mapbox_api_key" >> .env
echo "MAPBOX_MAP_STYLE=$mapbox_map_style" >> .env
echo "LOG_CHANNEL=$log_channel" >> .env
echo "DB_CONNECTION=$db_connection" >> .env
echo "DB_HOST=$db_host" >> .env
echo "DB_PORT=$db_port" >> .env
echo "DB_DATABASE=$db_database" >> .env
echo "DB_PASSWORD=$db_password" >> .env
echo "BROADCAST_DRIVER=$broadcast_driver" >> .env
echo "CACHE_DRIVER=$cache_driver" >> .env
echo "QUEUE_CONNECTION=$queue_connection" >> .env
echo "SESSION_DRIVER=$session_driver" >> .env
echo "SESSION_LIFETIME=$session_lifetime" >> .env
echo "REDIS_CLIENT=$redis_client" >> .env
echo "REDIS_HOST=$redis_host" >> .env
echo "REDIS_PASSWORD=$redis_password" >> .env
echo "REDIS_PORT=$redis_port" >> .env
echo "REDIS_QUEUE=$redis_queue" >> .env
echo "MAIL_MAILER=$mail_mailer" >> .env
echo "MAILGUN_DOMAIN=$mailgun_domain" >> .env
echo "MAILGUN_SECRET=$mailgun_secret" >> .env
echo "MAIL_HOST=$mail_host" >> .env
echo "MAIL_PORT=$mail_port" >> .env
echo "MAIL_USERNAME=$mail_username" >> .env
echo "MAIL_PASSWORD=$mail_password" >> .env
echo "MAIL_ENCRYPTION=$mail_encryption" >> .env
echo "MAIL_FROM_ADDRESS=$mail_from_address" >> .env
echo "MAIL_FROM_NAME=$mail_from_name" >> .env
echo "AWS_ACCESS_KEY_ID=$aws_access_key_id" >> .env
echo "AWS_SECRET_KEY_ID=$aws_secret_key_id" >> .env
echo "AWS_DEFAULT_REGION=$aws_default_region" >> .env
echo "AWS_BUCKET=$aws_bucket" >> .env
echo "PUSHER_APP_ID=$pusher_app_id" >> .env
echo "PUSHER_APP_KEY=$pusher_app_key" >> .env
echo "PUSHER_APP_SECRET=$pusher_app_secret" >> .env
echo "PUSHER_APP_CLUSTER=$pusher_app_cluster" >> .env
echo "MIX_PUSHER_APP_KEY=$mix_pusher_app_key" >> .env
echo "MIX_PUSHER_APP_CLUSTER=$mix_pusher_app_cluster" >> .env

echo "Chmod .env"
chmod 666 .env
echo "Chmod Storage dir"
chmod -R 775 storage
echo "Chmod bootstrap/cache dir"
chmod -R 775 bootstrap/cache

role=${CONTAINER_ROLE:-app}

if [ "$app_env" != "local" ]; then
    echo "Caching configuration..."
    su www -p -c 'php artisan clear-compiled && php artisan config:cache && php artisan view:cache && php artisan optimize'
fi

if [ "$role" = "app" ]; then
    echo "Migration..."
    su www -p -c 'php artisan migrate --force'

    echo "Checking if link exists..."
    if [ -L ./public/storage ]; then
        echo "Removing storage link..."
        rm ./public/storage
    fi

    echo "Creating symbolic link..."
    su www -p -c 'php artisan storage:link'

    php-fpm

elif [ "$role" = "queue" ]; then
    echo "Running the queue..."
    su www -p -c 'php /var/www/html/artisan queue:work --verbose --tries=3 --timeout=90'

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
