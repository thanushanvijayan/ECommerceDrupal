# Use the Drupal image with Apache as a base
FROM drupal:9-apache

# Install the necessary tools
RUN apt-get update && apt-get install -y gnupg curl

# Fetch and import the required keys
RUN curl -sL "https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x0E98404D386FA1D9" | apt-key add -
RUN curl -sL "https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x648ACFD622F3D138" | apt-key add -
RUN curl -sL "https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x54404762BBB6E853" | apt-key add -
RUN curl -sL "https://keyserver.ubuntu.com/pks/lookup?op=get&search=0xBDE6D2B9216EC7A8" | apt-key add -

# Continue the build process as before
RUN apt-get update \
    && apt-get install -y git unzip libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

# Install Drush using Composer
RUN composer global require drush/drush \
    && ln -s /root/.composer/vendor/drush/drush/drush /usr/local/bin/drush
