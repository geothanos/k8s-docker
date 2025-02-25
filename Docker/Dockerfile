# Use Ubuntu 22.04 image
FROM ubuntu:22.04

# Set the Timezone to UTC
ENV TZ=UTC

# Set non-interactive mode to avoid tzdata prompt
ENV DEBIAN_FRONTEND=noninteractive

# Install packages, apache2, PHP and php-fpm
RUN apt-get update && apt-get install -y \
    tzdata \
    software-properties-common  \
    curl  \
    wget \
    sudo  \
    zip  \
    apache2  \
    composer \
    ghostscript  \
    libapache2-mod-php  \
    php  \
    php-bcmath  \
    php-curl \
    php-imagick  \
    php-intl  \
    php-json  \
    php-mbstring  \
    php-mysql \
    php-xml  \
    php-zip  \
    php-fpm \
    && apt-get clean

# Change php.ini in apache2 configuration
ADD php.ini /etc/php/8.3/apache2/php.ini

# ========================================
# Wordpress Installation and Configuration
# ========================================

RUN cd /var/www/html/  \
    && wget https://wordpress.org/latest.zip \
    && unzip latest.zip \
    && rm latest.zip

# Add apache sites-available configuration file
RUN cd /etc/apache2/sites-available
ADD wordpress.conf /etc/apache2/sites-available/wordpress.conf

# Set the necessary Apache environment variables
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data
ENV APACHE_PID_FILE=/var/run/apache2/apache2.pid
ENV APACHE_RUN_DIR=/var/run/apache2
ENV APACHE_LOCK_DIR=/var/lock/apache2
ENV APACHE_LOG_DIR=/var/log/apache2
ENV APACHE_HOME=/usr/share/apache2

# Create necessary directories for Apache to run properly
RUN mkdir -p /var/run/apache2 /var/lock/apache2 /var/log/apache2

# Enable apache wordpress site
RUN a2ensite wordpress.conf  \
    && a2enmod rewrite \
    && service apache2 restart

# Add WordPress config file
#ADD ../wp-config.php /var/www/html/wordpress/wp-config.php

# Change the user and Permission of WordPress root directory
RUN chown -R www-data:www-data /var/www/html/wordpress && chmod -R 755 /var/www/html/wordpress

# =====================================
# Omeka Installation and Configuration
# =====================================

# Download and move wordpress installation folder
RUN cd /var/www/html/ \
    && wget https://github.com/omeka/omeka-s/releases/download/v4.1.0/omeka-s-4.1.0.zip \
    && unzip omeka-s-4.1.0.zip && mv omeka-s omeka

# Add omeka database.ini configuration file
ADD database.ini /var/www/html/omeka/config/database.ini

# Change the user and Permission of WordPress root directory
RUN chown -R www-data:www-data /var/www/html/omeka && chmod -R 755 /var/www/html/omeka

# Composer install in omeka folder
RUN cd /var/www/html/omeka  \
    && sudo -u www-data composer install

# Install omeka plugins
#######################

# Exposing container to port 80
EXPOSE 80

# Copy the startup script and give executable permission
COPY startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Command to run Apache in the foreground
CMD ["apache2ctl", "-D", "FOREGROUND"]

# Command to run the startup script
CMD ["/usr/local/bin/startup.sh"]