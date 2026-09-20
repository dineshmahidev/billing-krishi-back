FROM php:8.2-apache
RUN apt-get update && apt-get install -y libpng-dev libonig-dev libxml2-dev zip unzip git && docker-php-ext-install pdo_mysql gd mbstring
RUN a2enmod rewrite
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN chown -R www-data:www-data storage bootstrap/cache certs && chmod -R 775 storage bootstrap/cache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
EXPOSE 80
CMD php artisan config:clear && php artisan migrate --force && apache2-foreground
