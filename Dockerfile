FROM php:8.4-apache

# Install ekstensi database yang diperlukan Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Aktifkan mod_rewrite Apache untuk routing Laravel
RUN a2enmod rewrite

# Atur Document Root Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy semua file projek ke dalam server
COPY . /var/www/html

# Atur permission folder storage dan cache agar bisa ditulis oleh server
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

WORKDIR /var/www/html