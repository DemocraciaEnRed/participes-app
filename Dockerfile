FROM php:7.2-fpm

# Add user for laravel application
RUN groupadd -g 101 www && useradd -u 101 -ms /bin/bash -g www www

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libmagickwand-dev \
    libmagickcore-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd
RUN pecl install -o -f redis imagick && rm -rf /tmp/pear && docker-php-ext-enable redis imagick

# Install composer and setup dependencies
COPY --chown=www:www . .
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install && chown -R www:www .

# Setup entrypoint (including development script)
RUN cp docker/start.sh /usr/local/bin/start && chmod +x /usr/local/bin/start

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["/usr/local/bin/start"]
