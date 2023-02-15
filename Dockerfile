FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Add user for laravel application
#RUN groupadd -g 101 laravel && useradd -u 101 -ms /bin/bash -g laravel laravel

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    git \
    curl \
    locales \
    vim \
    libzip-dev \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    jpegoptim optipng pngquant gifsicle \
    libmagickwand-dev \
    libmagickcore-dev \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd
RUN pecl install -o -f redis imagick && rm -rf /tmp/pear && docker-php-ext-enable redis imagick


# Install composer and setup dependencies
# COPY --chown=laravel:laravel . .
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN composer install && chown -R laravel:laravel .

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user && \
    chown -R $user:$user /var/www/


# Set working directory
WORKDIR /var/www
ADD composer.json ./
RUN composer install --prefer-dist --no-scripts --no-autoloader --no-interaction --no-ansi --optimize-autoloader

# Setup entrypoint (including development script)
# RUN cp docker/start.sh /usr/local/bin/start && chmod +x /usr/local/bin/start
COPY docker/start.sh /usr/local/bin/start
RUN chown -R laravel: /var/www \
    && chmod u+x /usr/local/bin/start

COPY docker/supervisord.conf /etc/supervisor/conf.d/worker.conf

# Expose port 9000 and start php-fpm server

EXPOSE 9000

CMD ["/usr/local/bin/start"]
