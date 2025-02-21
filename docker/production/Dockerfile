## SET UP THE IMAGE ############################################################
# From image php:{x.y}-fpm
# Readme: /docker/base/README.md
################################################################################
ARG BASE_IMAGE_NAME
FROM ${BASE_IMAGE_NAME:-'base:latest'}

## SET ENVs ####################################################################
ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PHP_MAJOR_MINOR_VERSION=${PHP_MAJOR_MINOR_VERSION:-''}

## MANDATORY SOFTWARE INSTALLATION #############################################
RUN set -eux; \
    # Debian version.
    readonly _DEBIAN_MAJOR_RELEASE=$(echo $(lsb_release -rs) | awk -F'.' 'NR>0{print $1}' | sed 's/v//g'); \
    # Fixes: With Debian 9(Stretch) upgrade Nginx repository.
    if [ ${_DEBIAN_MAJOR_RELEASE} -eq 9 ]; then \
        { \
            echo 'deb http://nginx.org/packages/mainline/debian/ stretch nginx'; \
            echo 'deb-src http://nginx.org/packages/mainline/debian/ stretch nginx'; \
        } > /etc/apt/sources.list.d/nginx.list; \
        wget -qO - https://nginx.org/keys/nginx_signing.key | apt-key add -; \
    fi; \
    # Update system packages.
    apt-get update -y; \
    # Install system dependencies.
    apt-get install -y --no-install-recommends logrotate cron supervisor nginx; \
    # Remove default Logrotate/Crontab configuration.
    rm -rf /etc/logrotate.d/* /etc/cron.d/* /etc/cron.hourly/* /etc/cron.daily/* /etc/cron.weekly/* /etc/cron.monthly/*; \
    mv /etc/crontab /etc/crontab.bak; \
    # Remove default Nginx configuration.
    rm -rf /etc/nginx/conf.d/default* /etc/nginx/sites-enabled/default* /var/www/html/*; \
    # Cleanup: build deps and cache.
    rm -rf /tmp/* /var/tmp/* \
        /var/cache/apt/* /var/lib/apt/lists/* \
        /var/log/lastlog /var/log/faillog \
        /usr/src/*; \
    apt-get clean; \
    echo 'INFO: PACKAGES INSTALLATION COMPLETED.' >&1;

## SET WORKING DIRECTORY #######################################################
WORKDIR /var/www/html

## COPY SOURCE CODE ############################################################
COPY --chown=www-data:www-data ./ ./

## APPLICATION CONFIGURATION ###################################################
RUN set -eux; \
    apt-get update -y; \
    \
    ## COMPOSER INSTALL ########################################
    composer install --optimize-autoloader --no-dev --no-plugins --no-scripts; \
    composer clear-cache; \
    \
    ## DEPLOYMENT CONFIGURATION ################################
    # Chmod storage and cache.
    chown -R www-data:www-data ./vendor; \
    chmod -R 777 ./storage ./bootstrap/cache; \
    chown -R www-data:www-data ./storage ./bootstrap/cache; \
    # Trick chown `node_modules` folder not error.
    mkdir -p ./node_modules; \
    chown -R www-data:www-data ./node_modules; \
    # Copy default ENV file.
    php -r "file_exists('.env') || file_exists('.env-prod.env') && copy('.env-prod.env', '.env');"; \
    touch .env && chown www-data:www-data .env; \
    # Generate APP_KEY.
    php artisan key:generate --force --ansi; \
    # Generate JWT secret.
    php artisan jwt:secret --force --ansi; \
    # Generate Storage link.
    php artisan storage:link --force; \
    chown -R www-data:www-data ./public; \
    # Generate L5-Swagger.
    php artisan l5-swagger:generate --all; \
    chown -R www-data:www-data ./storage/api-docs; \
    # Reset cache (trick cache:clear not error).
    mkdir -p ./storage/framework/cache/data; \
    chmod -R 777 ./storage/framework/cache/data; \
    chown -R www-data:www-data ./storage/framework/cache/data; \
    php artisan optimize:clear; \
    \
    # TODO: Add new step to here.
    \
    # Delete unused base directories.
    rm -rf ./docker ./documents; \
    echo 'INFO: APPLICATION CONFIGURATION COMPLETED.' >&1;

## COPY CONFIGURATION FILES ####################################################
# For PHP
COPY ./docker/container/php/default/php${PHP_MAJOR_MINOR_VERSION}.ini-production ${PHP_INI_DIR}/php.ini
COPY ./docker/container/php/production/ ${PHP_INI_DIR}/
# For PHP-FPM
COPY ./docker/container/php-fpm/default/php-fpm${PHP_MAJOR_MINOR_VERSION}.conf-default ${FPM_CONF_DIR}/php-fpm.conf
COPY ./docker/container/php-fpm/default/conf.d/www${PHP_MAJOR_MINOR_VERSION}.conf-default ${FPM_CONF_DIR}/php-fpm.d/www.conf
COPY ./docker/container/php-fpm/production/conf.d/zz-www.conf ${FPM_CONF_DIR}/php-fpm.d/zz-www.conf
COPY ./docker/container/php-fpm/production/conf.d/zz-www${PHP_MAJOR_MINOR_VERSION}-expand.conf ${FPM_CONF_DIR}/php-fpm.d/zz-www-expand.conf
# For NGINX
COPY ./docker/container/nginx/common/ /etc/nginx/
COPY ./docker/container/nginx/production/ /etc/nginx/
# Replace for Nginx old versions.
RUN set -eux; \
    readonly _NGINX_MAJOR_MINOR_VERSION=$(echo $(nginx -v 2>&1) | grep -o '[0-9.]*$' | grep -o '^[0-9]*.[0-9]*'); \
    if [ "${_NGINX_MAJOR_MINOR_VERSION}" = '1.10' ] && [ -f '/etc/nginx/conf.d/default.conf' ]; then \
        sed -i "s|TLSv1.3||i" "/etc/nginx/conf.d/default.conf"; \
        sed -i "s|#REQUEST_ID:||i" "/etc/nginx/conf.d/default.conf"; \
    fi; \
    echo '' >&1;
# For SUPERVISORD
COPY ./docker/container/supervisor/common/ /etc/supervisor/
COPY ./docker/container/supervisor/production/ /etc/supervisor/
# For LOGROTATE and CRONTAB
COPY --chown=root:root ./docker/container/logrotate/common/ /etc/
COPY --chown=root:root ./docker/container/crontab/common/ /etc/
RUN chmod -R 0644 /etc/logrotate.d/* && chmod 0644 /etc/crontab && chmod -R 0755 /etc/cron.daily/*;
# For IMPORT ENV SCRIPT(import_env.php).
COPY --chown=www-data:www-data ./docker/common/import_env.php ./import_env.php
# For ENTRYPOINT
COPY ./docker/production/start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]
