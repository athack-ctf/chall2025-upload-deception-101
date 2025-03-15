FROM php:8.1-apache

WORKDIR /var/www/html

COPY chall /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN mkdir -p /var/www/html/uploads && chown -R www-data:www-data /var/www/html/uploads \
    && chmod -R 777 /var/www/html/uploads

RUN docker-php-ext-install exif && docker-php-ext-enable exif

COPY chall/php.ini /usr/local/etc/php/

RUN a2enmod rewrite


# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
