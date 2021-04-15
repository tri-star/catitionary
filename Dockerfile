FROM php:8.0-fpm

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

RUN curl -L https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /app

# COPY composer.json composer.lock /app/
# RUN composer install --no-autoloader --no-progress

COPY . /app/

# RUN composer dump-autoload -o

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
