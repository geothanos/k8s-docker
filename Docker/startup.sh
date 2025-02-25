#!/bin/bash

# Replace placeholders in wp-config.php with environment variables
WP_CONFIG="/var/www/html/wordpress/wp-config.php"

#sed -i "s/\${DB_NAME}/${DB_NAME}/g" $WP_CONFIG
sed -i "s/\${DB_USER}/${DB_USER}/g" $WP_CONFIG
sed -i "s/\${DB_PASSWORD}/${DB_PASSWORD}/g" $WP_CONFIG
sed -i "s/\${DB_HOST}/${DB_HOST}/g" $WP_CONFIG

# Start php-fpm
service php8.2-fpm start

# Start Apache in the foreground
apache2ctl -D FOREGROUND
