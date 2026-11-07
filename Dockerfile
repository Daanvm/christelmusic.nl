FROM php:8.5-apache AS base

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY app /var/www/html

FROM base AS builder

# Install php dependencies
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions imagick pcntl zip bcmath

# Install composer dependencies
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
RUN composer install

ADD .env.example .env

# Create cache
RUN /var/www/html/scripts/christelmusic warmup

FROM builder AS zipper

RUN cd /var/www/html && tar -czvf /build.tar.gz .

FROM base

RUN a2enmod rewrite

COPY --from=builder /var/www/html/vendor /var/www/html/vendor
COPY --from=builder /var/www/html/cache /var/www/html/cache
