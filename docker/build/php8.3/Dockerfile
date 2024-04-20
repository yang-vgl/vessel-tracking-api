FROM php:8.3.0-fpm-alpine3.18

# System update
RUN apk update && apk upgrade
RUN apk add --update linux-headers

# Install system dependencies
RUN apk add --no-cache git                  \
                       curl                 \
                       wget                 \
                       unzip                \
                       make                 \
                       ca-certificates      \
                       imagemagick          \
                       imagemagick-libs     \
                       imagemagick-dev      \
                       zip                  \
                       libzip-dev           \
                       openssh              \
                       sqlite               \
                       $PHPIZE_DEPS

# Install php dependencies
RUN pecl install redis                  \
                 xdebug                 \
                 imagick                \
                 pcov
RUN docker-php-ext-install opcache      \
                           mysqli       \
                           pdo          \
                           pdo_mysql    \
                           zip          \
                           pcntl        \
                           bcmath       \
                           sockets
RUN docker-php-ext-enable redis			\
                          imagick

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.6.5

# Install phpcov
RUN wget -q -O /usr/local/bin/phpcov https://phar.phpunit.de/phpcov-9.0.2.phar && chmod +x /usr/local/bin/phpcov

COPY cli.ini.dist /usr/local/etc/php/cli.ini
