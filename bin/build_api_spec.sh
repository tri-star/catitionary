set -ex

BASE_DIR=$(realpath $(dirname $0)/..)

docker run --rm \
  -u $UID \
  -v "${BASE_DIR}/openapi:/src" \
  openapitools/openapi-generator-cli generate \
    -g openapi-yaml \
    -i /src/root.yml \
    -o /src/specs
