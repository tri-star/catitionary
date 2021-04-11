#!/bin/bash


# if [ "${USE_TEST_DB}" ]; then
#     mysql -u root -psecret -h db -e "create database if not exists work_logger_test"
#     mysql -u root -psecret -h db -e "grant all privileges on work_logger_test.* to work_logger@'%' identified by 'secret'"
# fi

exec "$@"
