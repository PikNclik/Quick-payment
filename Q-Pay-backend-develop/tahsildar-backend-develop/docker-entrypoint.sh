#!/bin/bash

cp -R /var/www/tmp/. /var/www/html/
chown -R www-data:www-data /var/www/html
/usr/local/bin/php /var/www/html/artisan migrate
/usr/local/bin/php /var/www/html/artisan storage:link
/usr/local/bin/php /var/www/html/artisan queue:work &
echo "192.168.18.10     payment.piknclk.com" >> /etc/hosts
service cron start
echo ' * * * * * /usr/local/bin/php  /var/www/html/artisan schedule:run' > /etc/cron.d/schedule-run
crontab /etc/cron.d/schedule-run
printenv | grep -v "no_proxy" >> /etc/environment
php artisan queue:restart

exec "$@"
