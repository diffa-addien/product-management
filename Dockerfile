# Gunakan image PHP resmi dengan versi yang sesuai
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install dependensi sistem dan ekstensi PHP yang diperlukan
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install intl zip pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy aplikasi CI4 ke container
COPY . .

# Install dependensi PHP
RUN composer install --no-dev --optimize-autoloader

# Set document root ke folder `public`
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Aktifkan mod rewrite Apache
RUN a2enmod rewrite

# Expose port 80
EXPOSE 8080

# Jalankan Apache
CMD ["apache2-foreground"]