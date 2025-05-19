FROM php:8.2-fpm-alpine
COPY index.php /var/www/html/
WORKDIR /var/www/html
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]