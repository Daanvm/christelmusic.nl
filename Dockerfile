FROM php:8.1-apache as base

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY app /var/www/html

FROM base as builder

# Install php dependencies
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions imagick pcntl zip

# Install composer dependencies
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
RUN composer install

# Allow the creation of pdf files
RUN sed -i '/disable ghostscript format types/,+6d' /etc/ImageMagick-6/policy.xml

COPY .env.example .env

# Create cache
# DEBUG:
RUN ls -lah /var/www/html/src/../public/assets/sheetmusic/landslide/Butterflies.pdf
RUN ls -lah /var/www/html/public/assets/sheetmusic/landslide/Butterflies.pdf
RUN ls -lah /var/www/html/public/assets/sheetmusic/landslide
RUN ls -lah /var/www/html/public/assets/sheetmusic
RUN ls -lah /var/www/html/public/assets

RUN /var/www/html/scripts/christelmusic warmup

FROM builder as zipper

RUN cd /var/www/html && tar -czvf /build.tar.gz .

FROM base

RUN a2enmod rewrite

COPY --from=builder /var/www/html/vendor /var/www/html/vendor
COPY --from=builder /var/www/html/cache /var/www/html/cache
