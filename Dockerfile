FROM php:8.0-apache

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

#RUN composer install

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
#    mysql-client \
    locales \
    git \
    unzip \
    zip \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql exif pcntl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN composer install

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

RUN chmod 777 /var/www/

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
#EXPOSE 9000
#CMD ["php-fpm"]
#CMD ["php", "artisan", "key:generate"]
#CMD ["composer", "install", "&&", "php", "artisan", "serve", "--host", "0.0.0.0"]
CMD bash -c "composer install && php artisan serve --host 0.0.0.0"
