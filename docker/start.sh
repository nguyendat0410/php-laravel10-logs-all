#!/bin/sh

# composer update
/usr/local/bin/composer update >> /var/www/html/storage/logs/composer.log 2>&1 &

# php artisan migrate
/usr/local/bin/php /var/www/html/artisan migrate >> /var/www/html/storage/logs/php.log 2>&1 &

# Start supervisord and services
/usr/bin/supervisord -n -c /etc/supervisord.conf

#service cron start & cron -f & tail -f /var/log/cron.log
