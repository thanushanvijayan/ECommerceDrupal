# Dockerfile

# Use the specified image as the base
FROM drupal:9.2.0-php8.0-apache

# Install the Xdebug PHP extension
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Copy custom configuration files into the container
COPY ./custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini
