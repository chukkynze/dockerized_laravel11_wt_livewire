#nano /etc/php/8.3/mods-available/xdebug.ini
sed -i "s|xdebug.client_host=.*|xdebug.client_host=$(ip route show default | awk '/default/ {print $3}')|g" /etc/php/8.1/mods-available/xdebug.ini
service php8.3-fpm restart
# php -d xdebug.mode=coverage -r "require 'vendor/bin/phpunit';" -- --configuration phpunit.xml --do-not-cache-result --coverage-clover build/logs/clover.xml --coverage-html build/coverage

