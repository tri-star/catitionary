sudo rm -rf mock/php
docker run --rm -v ${PWD}:/local openapitools/openapi-generator-cli list
docker run --rm -v ${PWD}:/local openapitools/openapi-generator-cli generate \
    -i /local/swagger/swagger.yml \
    -g php-lumen \
    -o /local/mock/php
