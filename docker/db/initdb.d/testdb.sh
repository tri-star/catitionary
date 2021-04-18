mysql -u root -psecret -e "create database if not exists catitionary_test"
mysql -u root -psecret -e "grant all privileges on catitionary_test.* to cat@'%'"
