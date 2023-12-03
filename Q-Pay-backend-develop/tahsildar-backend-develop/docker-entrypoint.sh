#!/bin/bash

cp -R /var/www/tmp/. /var/www/html/
chown -R www-data:www-data /var/www/html
/usr/local/bin/php /var/www/html/artisan migrate
/usr/local/bin/php /var/www/html/artisan storage:link
/usr/local/bin/php /var/www/html/artisan queue:work &
service cron start
echo ' * * * * * /usr/local/bin/php  /var/www/html/artisan schedule:run' > /etc/cron.d/schedule-run
crontab /etc/cron.d/schedule-run
printenv | grep -v "no_proxy" >> /etc/environment
exec "$@"
