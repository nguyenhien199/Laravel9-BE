## SET UP THE IMAGE ############################################################
# From image php:{x.y}-fpm
# Readme: /docker/base/README.md
################################################################################
ARG BASE_IMAGE_NAME
FROM ${BASE_IMAGE_NAME:-'base:latest'}

## SET ARGs ####################################################################
ARG WWWGROUP

## SET ENVs ####################################################################
ENV DEBIAN_FRONTEND=noninteractive
ENV PHP_MAJOR_MINOR_VERSION=${PHP_MAJOR_MINOR_VERSION:-}

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

## APPLICATION CONFIGURATION ###################################################
RUN set -eux; \
    apt-get update -y; \
    # Create www-data user and change php-fpm user.
    groupmod -o -g ${WWWGROUP:-1000} www-data; \
    usermod -s /bin/bash -g ${WWWGROUP:-1000} -o -u 1337 www-data; \
    \
    # TODO: Add new step to here.
    \
    echo 'INFO: APPLICATION CONFIGURATION COMPLETED.' >&1;

## COPY CONFIGURATION FILES ####################################################
# For PHP
COPY ./docker/container/php/default/php${PHP_MAJOR_MINOR_VERSION}.ini-development ${PHP_INI_DIR}/php.ini
COPY ./docker/container/php/development/ ${PHP_INI_DIR}/
# For PHP-FPM
COPY ./docker/container/php-fpm/default/php-fpm${PHP_MAJOR_MINOR_VERSION}.conf-default ${FPM_CONF_DIR}/php-fpm.conf
COPY ./docker/container/php-fpm/default/conf.d/www${PHP_MAJOR_MINOR_VERSION}.conf-default ${FPM_CONF_DIR}/php-fpm.d/www.conf
COPY ./docker/container/php-fpm/development/conf.d/zz-www.conf ${FPM_CONF_DIR}/php-fpm.d/zz-www.conf
COPY ./docker/container/php-fpm/development/conf.d/zz-www${PHP_MAJOR_MINOR_VERSION}-expand.conf ${FPM_CONF_DIR}/php-fpm.d/zz-www-expand.conf
# For NGINX
COPY ./docker/container/nginx/common/ /etc/nginx/
COPY ./docker/container/nginx/development/ /etc/nginx/
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
COPY ./docker/container/supervisor/development/ /etc/supervisor/
# For LOGROTATE and CRONTAB
COPY --chown=root:root ./docker/container/logrotate/common/ /etc/
COPY --chown=root:root ./docker/container/crontab/common/ /etc/
RUN chmod -R 0644 /etc/logrotate.d/* && chmod 0644 /etc/crontab && chmod -R 0755 /etc/cron.daily/*;
# For ENTRYPOINT
COPY ./docker/development/start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]
