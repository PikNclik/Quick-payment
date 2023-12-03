FROM php:8.1-apache

# Install packages
RUN apt-get update && apt-get install -y \
    git \
    zip \
    vim \
    curl \
    sudo \
    cron \
    unzip \
    libzip-dev \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libxml2-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++

# Apache configuration
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers
#RUN pecl install mcrypt-1.0.4

# Common PHP Extensions
RUN docker-php-ext-install \
    gd \
    bz2 \
    zip  \
    intl  \
    soap   \
 #   mcrypt  \
    iconv    \
    bcmath    \
    ctype     \
    opcache    \
    calendar    \
    pdo_mysql


# Ensure PHP logs are captured by the container
ENV LOG_CHANNEL=stderr

# Set a volume mount point for your code
VOLUME /var/www/html

# Copy code and run composer
#COPY --from=composer:1.10.1 /usr/bin/composer /usr/bin/composer
COPY --from=composer  /usr/bin/composer /usr/bin/composer
COPY . /var/www/tmp
RUN cd /var/www/tmp && composer install  --ignore-platform-reqs

# Ensure the entrypoint file can be run
RUN chmod +x /var/www/tmp/docker-entrypoint.sh
ENTRYPOINT ["/var/www/tmp/docker-entrypoint.sh"]
#RUN /usr/bin/php artisan generate key

# The default apache run command
CMD ["apache2-foreground"]

