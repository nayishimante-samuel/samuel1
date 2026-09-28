FROM php:8.4-apache

RUN docker-php-ext-install mysqli \
    && printf '%s\n' \
        '<DirectoryMatch "^/var/www/html/(config|includes|database)(/|$)">' \
        '    Require all denied' \
        '</DirectoryMatch>' \
        > /etc/apache2/conf-available/portfolio-security.conf \
    && a2enconf portfolio-security

WORKDIR /var/www/html
COPY . /var/www/html

EXPOSE 80
