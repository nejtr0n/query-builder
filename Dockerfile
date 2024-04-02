FROM php:8.3-alpine

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin \
        --filename=composer
# Install Phpunit
RUN curl -o /usr/local/bin/phpunit https://phar.phpunit.de/phpunit-10.5.16.phar && chmod +x /usr/local/bin/phpunit
USER www-data
WORKDIR /app
COPY . /app
RUN composer install
CMD ["phpunit"]

