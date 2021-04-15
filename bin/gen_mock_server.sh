#!/bin/bash

# ------------------------------------------
# Open API Generatorでモックサーバーを立てる場合はこのスクリプトを使用する。
# 現時点では未使用
# ------------------------------------------

# 言語一覧
# docker run --rm -v ${PWD}:/local openapitools/openapi-generator-cli list

set -e

docker run --rm -v ${PWD}:/local openapitools/openapi-generator-cli generate \
    -i /local/swagger/swagger.yml \
    -g php-lumen \
    -o /local/mock/php

sudo chown -R $UID:$(id -g) ./mock/php
