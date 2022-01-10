FROM php:8.0-fpm AS runtime

ARG USER_UID=33
ARG USER_GID=33

RUN apt-get update --fix-missing \
    && apt-get upgrade -y \
    && apt-get install -y unzip curl libicu-dev \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/*

ADD .docker/services/php/bin /usr/local/bin/

# extensions
RUN docker-php-ext-install pdo pdo_mysql \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl

# working directory ownership
RUN chown -R www-data:www-data /var/www

# sync www-data uid/gid with host user
RUN /usr/local/bin/sync-user-id.sh www-data "$USER_UID" "$USER_GID"

ADD .docker/services/php/config/php-common-override.ini "$PHP_INI_DIR"/conf.d/

# entrypoint
ENTRYPOINT ["/usr/local/bin/run-app.sh"]

# ------------------------------------------------------------------------------
FROM runtime as development

# xdebug
RUN mkdir -p /usr/src/php/ext/xdebug \
&& curl -fsSL https://pecl.php.net/get/xdebug-3.0.1 | tar xvz -C "/usr/src/php/ext/xdebug" --strip 1 \
&& docker-php-ext-install xdebug
COPY .docker/services/php/config/xdebug.ini "$PHP_INI_DIR"/conf.d/

# composer
RUN /usr/local/bin/composer-installer.sh \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && composer --version

# composer settings
RUN install -o www-data -g www-data -d /var/www/.composer
ENV PATH="$PATH":/var/www/html/vendor/bin

USER www-data

# ------------------------------------------------------------------------------
FROM development as installer

USER root

ADD --chown=www-data . /var/www/html
RUN composer install --prefer-dist

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

USER www-data

# ------------------------------------------------------------------------------
FROM runtime as production

COPY --from=installer /var/www/html .
