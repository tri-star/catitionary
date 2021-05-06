FROM node:15-alpine AS js-builder

COPY ./package.json /app/package.json
COPY ./yarn.lock /app/yarn.lock

# RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
#   curl https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
#   echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

WORKDIR /app

RUN yarn install --pure-lockfile
COPY ./.env /app/.env
COPY ./webpack.config.js /app/webpack.config.js
COPY ./babel.config.js /app/babel.config.js
COPY ./javascript /app/javascript
RUN yarn build


FROM nginx:1.19-alpine AS web

COPY ./docker/web/templates/default.conf.template /etc/nginx/templates/default.conf.template
COPY --from=js-builder /app/dist /app/public


FROM php:8.0-fpm AS base

ARG UID=1000
ARG GID=1000

RUN groupadd -g $GID app_user
RUN useradd -m -u $UID -g $GID -s /bin/bash app_user

RUN apt update && \
  apt install -y locales \
  lsb-release wget gnupg \
  git unzip zlib1g-dev libzip-dev vim default-mysql-client && \
  locale-gen ja_JP.UTF-8 && \
  echo "export LANG=ja_JP.UTF-8" >> ~/.bashrc && \
  apt autoremove -y && \
  apt clean && \
  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install opcache

COPY ./docker/app/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN curl -L https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /app

COPY composer.json composer.lock /app/
RUN composer install --no-autoloader --no-progress --no-dev

COPY . /app/

RUN composer dump-autoload --optimize

# TODO
# COPY .env.production.dist /app/.env
COPY ./docker/app/entrypoint.sh /entrypoint.sh
RUN chmod 755 /entrypoint.sh

RUN mkdir -p /app/bootstrap/cache && \
  mkdir -p /app/storage/app/public && \
  mkdir -p /app/storage/framework/cache && \
  mkdir -p /app/storage/framework/sessions && \
  mkdir -p /app/storage/framework/views && \
  mkdir -p /app/storage/logs && \
  chmod -R go+w /app/storage && \
  chmod -R go+w /app/bootstrap/cache


CMD ["php-fpm", "-F"]
ENTRYPOINT ["/entrypoint.sh"]

USER app_user


FROM base AS local

USER root

RUN curl -fsSL https://deb.nodesource.com/setup_15.x | bash - && \
  curl https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
  echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN apt update && \
  apt install -y locales \
  nodejs yarn && \
  apt autoremove -y && \
  apt clean && \
  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install xdebug && \
  docker-php-ext-enable xdebug

COPY docker/app/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY docker/app/opcache_local.ini /usr/local/etc/php/conf.d/opcache.ini

USER app_user
