# Use Ubuntu 22.04 image
FROM ubuntu:22.04

# Set the Timezone to UTC
ENV TZ=UTC

# Install some packages and apache2
RUN apt-get update
RUN apt-get install -y \
    software-properties-common curl wget \
    sudo zip apache2 composer

# Install PHP and php-fpm
RUN apt-get update
RUN apt-get install -y \
    ghostscript libapache2-mod-php php php-bcmath php-curl \
    php-imagick php-intl php-json php-mbstring php-mysql \
    php-xml php-zip php-fpm \

# Change php.ini in apache2 configuration
ADD php.ini /etc/php/8.3/apache/

# ========================================
# Wordpress Installation and Configuration
# ========================================

RUN cd /var/www/html/
RUN wget https://wordpress.org/latest.zip \
    && unzip latest.zip \
    && rm latest.zip

# Add apache sites-available configuration file
RUN cd /etc/apache2/sites-available
ADD wordpress.conf /etc/apache2/sites-available

# Enable apache wordpress site
RUN a2ensite wordpress.conf  \
    && a2enmode rewrite \
    && systemctl restart apache2

# Create a symbolic link
RUN ln -s /etc/nginx/sites-available/wordpress.conf /etc/nginx/sites-enabled/

# Add WordPress config file
ADD wp-config.php /var/www/html/wordpress/wp-config.php

# Change the user and Permission of WordPress root directory
RUN chown -R www-data:www-data /var/www/html/wordpress && chmod -R 755 /var/www/html/wordpress

# =====================================
# Omeka Installation and Configuration
# =====================================

# Download and move wordpress installation folder
RUN cd /var/www/html/
RUN wget https://github.com/omeka/omeka-s/releases/download/v4.1.0/omeka-s-4.1.0.zip
RUN unzip omeka-s-4.1.0.zip && mv omeka-s omeka

# Add omeka database.ini configuration file
ADD database.ini /var/www/html/omeka/config/database.ini

# Change the user and Permission of WordPress root directory
RUN chown -R www-data:www-data /var/www/html/omeka && chmod -R 755 /var/www/html/omeka

# Composer install in omeka folder
RUN cd /var/www/html/omeka
RUN sudo -u www-data composer install

# Install omeka plugins
#######################

# Exposing container to port 80
EXPOSE 80

# Copy the startup script and give executable permission
COPY startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Command to run the startup script
CMD ["/usr/local/bin/startup.sh"]