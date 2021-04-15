FROM php:7.4-cli

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

RUN mkdir /app

WORKDIR /app

USER app_user
