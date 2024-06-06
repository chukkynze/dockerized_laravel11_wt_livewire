#!/usr/bin/env bash

echo ""
echo ""
echo "================================================"
echo "= WEBAPP BUILD"
echo "================================================"
echo ""

if [[ $1 = 'local' ]];
then

    echo "Starting BUILD"
    echo ""

    # shellcheck disable=SC2164
    cd /var/www/html
	chown -R www-data:www-data /var/www/html
    chmod -R ugo+rwx /var/www/html

	php artisan down
	php artisan cache:clear
	php artisan clear-compiled
	php artisan config:clear

	composer self-update
	rm ./composer.lock
	composer update --no-interaction --no-cache --profile --prefer-dist
	composer update --dry-run roave/security-advisories

	find . -name "*.blade.php" -exec touch {} \;

	php artisan migrate:refresh --seed --force

	# supervisorctl stop client-worker:* && php artisan cache:clear && php artisan clear-compiled && composer dump-autoload && supervisorctl reread && supervisorctl update && supervisorctl start client-worker:* && supervisorctl status

	supervisorctl stop client-worker:*
    php artisan cache:clear
    php artisan clear-compiled
	php artisan config:clear
    composer dump-autoload
	supervisorctl reread
	supervisorctl update
	supervisorctl start client-worker:*
    supervisorctl status

    php artisan clear-compiled
	# php artisan ide-helper:meta
	# php artisan ide-helper:generate
	php artisan ide-helper:models -W -R -n

    php artisan queue:restart

	php artisan up

    ./updt_xdebug.sh

    service nginx start

    echo ""
    echo ""
    echo "Ending BUILD"
    echo ""

elif [[ $1 = 'local-test' ]]; then

	php artisan down
	php artisan cache:clear
	php artisan clear-compiled

	composer self-update
	composer install
	composer update

	find . -name "*.blade.php" -exec touch {} \;

	#sudo npm install
	#sudo npm update

	#sudo gulp once

	php artisan migrate:refresh --seed --force

	composer dump-autoload

	php artisan ide-helper:meta
	php artisan ide-helper:generate
	php artisan ide-helper:models -W

	php artisan up

    php ./vendor/bin/phpunit --coverage-text --coverage-xml code-coverage/xml
    vendor/bin/codecept run --steps

    coverageStatus=$(php -f code-coverage/coveragexmlparser.php)

	if [ "$coverageStatus" = 1 ]; then

      echo "Method Coverage is below acceptable threshold!" 1>&2
        exit 64

      elif [ "$coverageStatus" = 2 ]; then

      echo "Class Coverage is below acceptable threshold!" 1>&2
        exit 64

      elif [ "$coverageStatus" = 3 ]; then

      echo "Line Coverage is below acceptable threshold!" 1>&2
        exit 64

	fi

    rm -rf code-coverage/xml/*

else

	echo "Invalid environment called on deploy [${1}]. Valid options: local, dev, stg, prod."

fi
