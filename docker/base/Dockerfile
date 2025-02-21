## SET UP THE IMAGE ############################################################
# https://github.com/docker-library/docs/blob/master/php/README.md
#
# JV_PHP_VERSION: 8.4 | 8.3 | 8.2 | 8.1 | 8.0 | 7.4 | 7.3 | 7.2 | 7.1 | 7.0 | 5.6
# JV_DISTRIBUTION: bookworm | bullseye | buster | stretch
################################################################################
ARG JV_PHP_VERSION
ARG JV_DISTRIBUTION
FROM php:${JV_PHP_VERSION:-''}-fpm${JV_DISTRIBUTION:+'-'}${JV_DISTRIBUTION:-''} AS builder

LABEL maintainer='ThuyVu <thuyvv.hn@gmail.com>'

## SET ARGs ####################################################################
ARG JV_PHP_VERSION

## PHP EXTENSION OPTION INTALL #########
# (IMPORTANT: true|false is lowercase).
########################################
ARG JV_INSTALL_CALENDAR=false
ARG JV_INSTALL_BCMATH=false
ARG JV_INSTALL_ZIP=false
ARG JV_INSTALL_BZ2=false
ARG JV_INSTALL_DECIMAL=false
ARG JV_INSTALL_INTL=false
ARG JV_INSTALL_PCNTL=false
ARG JV_INSTALL_MCRYPT=false
ARG JV_INSTALL_MSGPACK=false
ARG JV_INSTALL_IGBINARY=false
ARG JV_INSTALL_GNUPG=false
ARG JV_INSTALL_YAML=false
ARG JV_INSTALL_XSL=false
ARG JV_INSTALL_XLSWRITER=false
ARG JV_INSTALL_OPCACHE=false
ARG JV_INSTALL_MEMCACHED=false
ARG JV_INSTALL_IMAP=false
ARG JV_INSTALL_LDAP=false
ARG JV_INSTALL_SOAP=false
ARG JV_INSTALL_SOCKET=false
ARG JV_INSTALL_SSH2=false
ARG JV_INSTALL_GD=false
ARG JV_INSTALL_EXIF=false
ARG JV_INSTALL_IMAGICK=false
ARG JV_INSTALL_MYSQL=false
ARG JV_INSTALL_PGSQL=false
ARG JV_INSTALL_MONGODB=false
ARG JV_INSTALL_MSSQL=false
ARG JV_INSTALL_SQLSRV=false
ARG JV_INSTALL_OCI8=false
ARG JV_INSTALL_REDIS=false
ARG JV_INSTALL_AMQP=false
ARG JV_INSTALL_EVENT=false

## XDEBUG ##############################
ARG JV_INSTALL_XDEBUG=false

## PHPUNIT #############################
ARG JV_INSTALL_PHPUNIT=false

## COMPOSER ############################
ARG JV_INSTALL_COMPOSER=false

## NODEJS ##############################
ARG JV_INSTALL_NODEJS=false
ARG JV_NODEJS_VERSION=22

## YARN ################################
ARG JV_INSTALL_YARN=false
ARG JV_YARN_VERSION_ONE=false

## BOWER ###############################
ARG JV_INSTALL_BOWER=false

## SASS ################################
ARG JV_INSTALL_SASS=false

## SET ENVs ####################################################################
ENV DEBIAN_FRONTEND=noninteractive
ENV FPM_CONF_DIR=/usr/local/etc
ENV PHP_MAJOR_MINOR_VERSION="${JV_PHP_VERSION}"

## COPY CONFIGURATION TEMPLATES ################################################
COPY ./config /tmp/config

## MANDATORY SOFTWARE INSTALLATION #############################################
RUN set -eux; \
    # PHP version.
    readonly _PHP_MAJOR_MINOR_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;"); \
    # Fixes: Debian 9(Stretch) repositories moved to archive.
    if [ ${_PHP_MAJOR_MINOR_VERSION} = '5.6' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ]; then \
        { \
            echo 'deb http://archive.debian.org/debian stretch main'; \
            echo 'deb http://archive.debian.org/debian-security stretch/updates main'; \
        } > /etc/apt/sources.list; \
    fi; \
    # Update system packages.
    apt-get update -yqq; \
    if [ ${_PHP_MAJOR_MINOR_VERSION} = '5.6' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ]; then \
        apt-get upgrade -yqq; \
    fi; \
    # Install system dependencies.
    apt-get install -yqq --no-install-recommends \
        apt-utils \
        apt-transport-https \
        lsb-release \
        curl wget \
        gnupg gnupg2 \
        zip unzip \
        git; \
    # Allow (`www-data` user) running as an arbitrary user.
    [ ! -d /var/www ] && { mkdir -p /var/www; }; \
    chown www-data:www-data /var/www && chmod 755 /var/www; \
    # Cleanup: build deps and cache.
    rm -rf /var/lib/apt/lists/*; \
    # Reconfigure tzdata.
    dpkg-reconfigure tzdata; \
    # Update channel (Update All: pecl update-channels).
    if [ ${_PHP_MAJOR_MINOR_VERSION} = '8.4' ] && [ $(echo $(pear version | awk '/PEAR\ Version/ {print $(NF)}')) = '1.10.15' ]; then \
        pear upgrade --force pear > /dev/null; \
    fi; \
    pecl channel-update pecl.php.net; \
    rm -rf /tmp/pear ~/.pearrc; \
    # Create a log directory for PHP.
    mkdir -p /var/log/php && chown www-data:www-data /var/log/php; \
    echo 'INFO: PACKAGES INSTALLATION COMPLETED.' >&1;

## VALIDATION ARGs #############################################################
RUN set -eux; \
    # PHP version.
    readonly _PHP_MAJOR_VERSION=$(php -r "echo PHP_MAJOR_VERSION;"); \
    readonly _PHP_MINOR_VERSION=$(php -r "echo PHP_MINOR_VERSION;"); \
    readonly _PHP_MAJOR_MINOR_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;"); \
    # Unix Hardware.
    readonly _UNIX_ARCHITECTURE="$(uname -m)"; \
    readonly _UNIX_IS_ARM="$(echo ${_UNIX_ARCHITECTURE} | grep -q -i -e "aarch\|arm" && echo 'true' || echo 'false')"; \
    # Debian version.
    readonly _DEBIAN_RELEASE=$(lsb_release -rs); \
    readonly _DEBIAN_MAJOR_RELEASE=$(echo ${_DEBIAN_RELEASE} | awk -F'.' 'NR>0{print $1}' | sed 's/v//g'); \
    \
    # PHP 5.x unsupported extensions.
    [ ${_PHP_MAJOR_VERSION} -eq 5 ] && { \
        [ "INSTALL_DECIMAL-${JV_INSTALL_DECIMAL}" = 'INSTALL_DECIMAL-true' ] && { \
            echo 'ERROR: For PHP 5.x, the `decimal` extension is not supported!' >&2 && exit -1; \
        }; \
        [ "INSTALL_XLSWRITER-${JV_INSTALL_XLSWRITER}" = 'INSTALL_XLSWRITER-true' ] && { \
            echo 'ERROR: For PHP 5.x, the `xlswriter` extension is not supported!' >&2 && exit -1; \
        }; \
        [ "INSTALL_SQLSRV/PDO_SQLSRV-${JV_INSTALL_SQLSRV}" = 'INSTALL_SQLSRV/PDO_SQLSRV-true' ] && { \
            echo 'ERROR: For PHP 5.x, `sqlsrv/pdo_sqlsrv` extensions are not supported!' >&2 && exit -1; \
        }; \
        [ "INSTALL_EVENT-${JV_INSTALL_EVENT}" = 'INSTALL_EVENT-true' ] && { \
            [ "INSTALL_SOCKETS-${JV_INSTALL_SOCKET}" != 'INSTALL_SOCKETS-true' ] && { \
                echo 'ERROR: For PHP 5.x, the `event` extension requires the `socket` extension to be included: `JV_INSTALL_SOCKET=true`!' >&2 && exit -1; \
            }; \
        }; \
    }; \
    # PHP >= 7.x unsupported extensions.
    [ ${_PHP_MAJOR_VERSION} -gt 5 ] && { \
        [ "INSTALL_MSSQL/PDO_DBLIB-${JV_INSTALL_MSSQL}" = 'INSTALL_MSSQL/PDO_DBLIB-true' ] && { \
            echo 'ERROR: As of PHP 7.0, `mssql/pdo_dblib` extensions are not supported!' >&2 && exit -1; \
        }; \
    }; \
    # PHP SQLSRV extension depends on the server hardware.
    [ "INSTALL_SQLSRV/PDO_SQLSRV-${JV_INSTALL_SQLSRV}" = 'INSTALL_SQLSRV/PDO_SQLSRV-true' ] && { \
        [ ${_DEBIAN_MAJOR_RELEASE} -le 10 ] && [ "${_UNIX_IS_ARM}" = 'true' ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian ${_DEBIAN_MAJOR_RELEASE} kernel - architecture '${_UNIX_ARCHITECTURE}', package 'msodbcsql18' is not supported!" >&2 && exit -1; \
        }; \
    }; \
    # PHP OCI8 extension depends on the server hardware.
    [ "INSTALL_ORACLE_OCI8-${JV_INSTALL_OCI8}" = 'INSTALL_ORACLE_OCI8-true' ] && { \
        [ ${_PHP_MAJOR_VERSION} -eq 5 ] && [ "${_UNIX_IS_ARM}" = 'true' ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian ${_DEBIAN_MAJOR_RELEASE} kernel - architecture '${_UNIX_ARCHITECTURE}', package 'oracle-instantclient' is not supported!" >&2 && exit -1; \
        }; \
    }; \
    # Supported versions of NodeJS depend on the version of Debian.
    [ "INSTALL_NODEJS-${JV_INSTALL_NODEJS}" = 'INSTALL_NODEJS-true' ] && { \
        [ ${_DEBIAN_MAJOR_RELEASE} -eq 9 ] && [ ${JV_NODEJS_VERSION} -ge 18 ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian 9(stretch) kernel, NODEJS version >=18 is not supported!" >&2 && exit -1; \
        }; \
        [ ${_DEBIAN_MAJOR_RELEASE} -eq 10 ] && [ ${JV_NODEJS_VERSION} -le 8 ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian 10(buster) kernel, NODEJS versions <=8 are no longer supported!" >&2 && exit -1; \
        }; \
        [ ${_DEBIAN_MAJOR_RELEASE} -eq 11 ] && [ ${JV_NODEJS_VERSION} -le 10 ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian 11(bullseye) kernel, NODEJS versions <=10 are no longer supported!" >&2 && exit -1; \
        }; \
        [ ${_DEBIAN_MAJOR_RELEASE} -eq 12 ] && [ ${JV_NODEJS_VERSION} -le 16 ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian 12(bookworm) kernel, NODEJS versions <=16 are no longer supported!" >&2 && exit -1; \
        }; \
    }; \
    # Source code managers depend on NodeJS installation.
    [ "INSTALL_NODEJS-${JV_INSTALL_NODEJS}" != 'INSTALL_NODEJS-true' ] && { \
        [ "INSTALL_YARN-${JV_INSTALL_YARN}" = 'INSTALL_YARN-true' ] && { \
            echo 'ERROR: YARN requires NODEJS to be included: `JV_INSTALL_NODEJS=true`!' >&2 && exit -1; \
        }; \
        [ "INSTALL_BOWER-${JV_INSTALL_BOWER}" = 'INSTALL_BOWER-true' ] && { \
            echo 'ERROR: BOWER requires NODEJS to be included: `JV_INSTALL_NODEJS=true`!' >&2 && exit -1; \
        }; \
        [ "INSTALL_SASS-${JV_INSTALL_SASS}" = 'INSTALL_SASS-true' ] && { \
            echo 'ERROR: SASS requires NODEJS to be included: `JV_INSTALL_NODEJS=true`!' >&2 && exit -1; \
        }; \
    }; \
    echo 'INFO: ARGUMENTS VALIDATION COMPLETED.' >&1;

## SOFTWARE's INSTALLATION AND PHP EXTENSIONS ##################################
#
# PHP Extensions software such as:
# ( 
#   Core / ctype / curl / date / dom / fileinfo / filter / hash / iconv
#   json / libxml / mbstring / mysqlnd / openssl / pcre / PDO / pdo_sqlite
#   Phar / posix / readline / Reflection / session / SimpleXML / SPL / sqlite3
#   standard / tokenizer / xml / xmlreader / xmlwriter / zlib
# )
# are installed on the base image 'php:${JV_PHP_VERSION}-fpm' image.
# (https://github.com/docker-library/php/tree/master/${JV_PHP_VERSION}/bullseye/fpm)
# Default in version:
# ==5.6 : (mhash / ereg)
# >=7.2 : (sodium)
# <=8.1 : (ftp)
# >=8.2 : (random)
################################################################################
RUN set -eux; \
    # Update system packages.
    apt-get update -yqq; \
    # Remove: DST Root CA X3 Expiration (September 2021).
    rm -rf /usr/share/ca-certificates/mozilla/DST_Root_CA_X3.crt; \
    \
    ## BASH VARIABLES DEFINITION ###################################################
    [ 'BASH_VARIABLES' = 'BASH_VARIABLES' ] && { \
        # Mark manual save.
        _MARK_APT_SAVED=$(apt-mark showmanual | sort -u | sed ':a;N;$!ba;s/\n/ /g'); \
        _MARK_PACKAGES=''; \
        # Work directory.
        readonly _WORKDIR=$(pwd); \
        # Config temp directory.
        readonly _CONF_TEMP_DIR='/tmp/config'; \
        # Unix Hardware.
        readonly _UNIX_ARCHITECTURE="$(uname -m)"; \
        readonly _UNIX_IS_ARM="$(echo ${_UNIX_ARCHITECTURE} | grep -q -i -e "aarch\|arm" && echo 'true' || echo 'false')"; \
        # PHP version.
        readonly _PHP_MAJOR_VERSION=$(php -r "echo PHP_MAJOR_VERSION;"); \
        readonly _PHP_MINOR_VERSION=$(php -r "echo PHP_MINOR_VERSION;"); \
        readonly _PHP_MAJOR_MINOR_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;"); \
        # Debian version.
        readonly _DEBIAN_RELEASE=$(lsb_release -rs); \
        readonly _DEBIAN_MAJOR_RELEASE=$(echo ${_DEBIAN_RELEASE} | awk -F'.' 'NR>0{print $1}' | sed 's/v//g'); \
        # The clarified GNU system type of the build machine, used for filesystem paths (since dpkg 1.16.0).
        readonly _DEB_BUILD_MULTIARCH=$(dpkg-architecture --query DEB_BUILD_MULTIARCH); \
        # Pecl configs.
        readonly _PECL_CONFIG_TEMP_DIR=$(pecl config-get temp_dir); \
    }; \
    \
    ## INSTALL THE PHP `sodium` EXTENSION ##########################################
    # With PHP 5.x, this extension is not supported.
    # As of PHP 7.2, this extension is bundled with PHP.
    # Requires:
    #   Packages: libsodium-dev(libsodium{xx})
    # Links:
    #   https://pecl.php.net/package/libsodium (stable: 2.0.23 | Release: 2020-12-06)
    ################################################################################
    [ 'INSTALL_SODIUM-true' = 'INSTALL_SODIUM-true' ] && { \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            echo 'INFO: For PHP 5.x, the `sodium` extension is not supported!' >&1; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.1' ]; then \
            _MARK_PACKAGES="${_MARK_PACKAGES} libsodium"; \
            apt-get install -yqq --no-install-recommends libsodium-dev; \
            _LIBSODIUM_VERSION='2.0.23'; \
            pecl install --force libsodium-${_LIBSODIUM_VERSION}; \
            docker-php-ext-enable sodium; \
        else \
            echo 'INFO: For PHP >=7.2, the `sodium` extension is bundled with PHP.' >&1; \
        fi; \
    }; \
    \
    ## INSTALL THE PHP `ftp` EXTENSION ##########################################
    # Until PHP 8.1, this extension is bundled with PHP.
    # Requires:
    #   Packages: libssl-dev(libssl{xx}.{yy} openssl libcrypto)
    ################################################################################
    [ 'INSTALL_FTP-true' = 'INSTALL_FTP-true' ] && { \
        if [ ${_PHP_MAJOR_VERSION} -le 7 ] || { [ ${_PHP_MAJOR_VERSION} -eq 8 ] && [ ${_PHP_MINOR_VERSION} -le 1 ]; }; then \
            echo 'INFO: For PHP <=8.1, the `ftp` extension is bundled with PHP.' >&1; \
        else \
            _MARK_PACKAGES="${_MARK_PACKAGES} libssl openssl libcrypto"; \
            apt-get install -yqq --no-install-recommends libssl-dev; \
            if [ ${_PHP_MAJOR_MINOR_VERSION} = '8.2' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '8.3' ]; then \
                docker-php-ext-configure ftp --enable-ftp --with-openssl-dir=/usr; \
            else \
                docker-php-ext-configure ftp --enable-ftp --with-ftp-ssl=/usr; \
            fi; \
            docker-php-ext-install -j$(nproc) ftp; \
        fi; \
    }; \
    \
    ## INSTALL THE PHP `calendar` EXTENSION ########################################
    [ "INSTALL_CALENDAR-${JV_INSTALL_CALENDAR}" = 'INSTALL_CALENDAR-true' ] && { \
        docker-php-ext-configure calendar --enable-calendar; \
        docker-php-ext-install -j$(nproc) calendar; \
    }; \
    \
    ## INSTALL THE PHP `bcmath` EXTENSION ##########################################
    [ "INSTALL_BCMATH-${JV_INSTALL_BCMATH}" = 'INSTALL_BCMATH-true' ] && { \
        docker-php-ext-configure bcmath --enable-bcmath; \
        docker-php-ext-install -j$(nproc) bcmath; \
    }; \
    \
    ## INSTALL THE PHP `zip` EXTENSION #############################################
    # Requires:
    #   Packages: libzip-dev(libzip{xx})
    ################################################################################
    [ "INSTALL_ZIP-${JV_INSTALL_ZIP}" = 'INSTALL_ZIP-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libzip"; \
        apt-get install -yqq --no-install-recommends libzip-dev; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ] || { [ ${_PHP_MAJOR_VERSION} -eq 7 ] && [ ${_PHP_MINOR_VERSION} -le 3 ]; }; then \
            docker-php-ext-configure zip --with-libzip; \
        else \
            docker-php-ext-configure zip --with-zip; \
        fi; \
        docker-php-ext-install -j$(nproc) zip; \
    }; \
    \
    ## INSTALL THE PHP `bz2` EXTENSION #############################################
    # Requires:
    #   Packages: libbz2-dev(libbz2-{xx})
    ################################################################################
    [ "INSTALL_BZ2-${JV_INSTALL_BZ2}" = 'INSTALL_BZ2-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libbz2"; \
        apt-get install -yqq --no-install-recommends libbz2-dev; \
        docker-php-ext-configure bz2 --with-bz2; \
        docker-php-ext-install -j$(nproc) bz2; \
    }; \
    \
    ## INSTALL THE PHP `decimal` EXTENSION #########################################
    # With PHP 5.x, this extension is not supported.
    # Requires:
    #   Packages: libmpdec-dev(libmpdec{xx})
    # Links:
    #   https://pecl.php.net/package/decimal (stable: 1.5.0 | Release: 2024-01-20)
    ################################################################################
    [ "INSTALL_DECIMAL-${JV_INSTALL_DECIMAL}" = 'INSTALL_DECIMAL-true' ] && { \
        [ ${_PHP_MAJOR_VERSION} -eq 5 ] && { echo 'ERROR: For PHP 5.x, the `decimal` extension is not supported!' >&2 && exit -1; }; \
        _MARK_PACKAGES="${_MARK_PACKAGES} mpdecimal libmpdec"; \
        if [ ${_DEBIAN_MAJOR_RELEASE} -le 11 ]; then \
            apt-get install -y --no-install-recommends libmpdec-dev; \
        else \
            wget --no-check-certificate --progress=bar:force:noscroll 'https://www.bytereef.org/software/mpdecimal/releases/mpdecimal-4.0.0.tar.gz' --output-document='/tmp/mpdecimal.tar.gz'; \
            mkdir -p /tmp/mpdecimal; \
            tar -zx --file='/tmp/mpdecimal.tar.gz' --directory='/tmp/mpdecimal' --strip 1; \
            cd /tmp/mpdecimal; \
            ./configure && make && make install; \
            cd ${_WORKDIR} && rm -rf /tmp/mpdecimal; \
        fi; \
        _DECIMAL_VERSION='1.5.0'; \
        pecl install decimal-${_DECIMAL_VERSION}; \
        docker-php-ext-enable decimal; \
    }; \
    \
    ## INSTALL THE PHP `intl` EXTENSION ############################################
    # Requires:
    #   Packages: libicu-dev(libicu{xx}, icu-devtools)
    ################################################################################
    [ "INSTALL_INTL-${JV_INSTALL_INTL}" = 'INSTALL_INTL-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libicu icu-devtools"; \
        apt-get install -yqq --no-install-recommends libicu-dev; \
        docker-php-ext-configure intl --enable-intl; \
        docker-php-ext-install -j$(nproc) intl; \
    }; \
    \
    ## INSTALL THE PHP `pcntl` EXTENSION ###########################################
    [ "INSTALL_PCNTL-${JV_INSTALL_PCNTL}" = 'INSTALL_PCNTL-true' ] && { \
        docker-php-ext-configure pcntl --enable-pcntl; \
        docker-php-ext-install -j$(nproc) pcntl; \
    }; \
    \
    ## INSTALL THE PHP `mcrypt` EXTENSION ##########################################
    # Requires:
    #   Packages: libmcrypt-dev(libmcrypt{xx})
    # Links:
    #   https://pecl.php.net/package/mcrypt (stable: 1.0.7 | Release: 2023-12-19)
    ################################################################################
    [ "INSTALL_MCRYPT-${JV_INSTALL_MCRYPT}" = 'INSTALL_MCRYPT-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libmcrypt"; \
        apt-get install -yqq --no-install-recommends libmcrypt-dev; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ] || { [ ${_PHP_MAJOR_VERSION} -eq 7 ] && [ ${_PHP_MINOR_VERSION} -le 1 ]; }; then \
            docker-php-ext-configure mcrypt --with-mcrypt; \
            docker-php-ext-install -j$(nproc) mcrypt; \
        elif [ ${_PHP_MAJOR_VERSION} -eq 7 ] || { [ ${_PHP_MAJOR_VERSION} -eq 8 ] && [ ${_PHP_MINOR_VERSION} -le 3 ]; }; then \
            _MCRYPT_VERSION='1.0.7'; \
            pecl install mcrypt-${_MCRYPT_VERSION}; \
            docker-php-ext-enable mcrypt; \
        else \
            echo 'INFO: For PHP >=8.4, the `mcrypt` extension is no longer supported.' >&1; \
        fi; \
    }; \
    \
    ## INSTALL THE PHP `msgpack` EXTENSION #########################################
    # With PHP 5.6 - using msgpack-0.5.7 version.
    # Links:
    #   https://pecl.php.net/package/msgpack (stable: 3.0.0 | Release: 2024-09-25)
    ################################################################################
    [ "INSTALL_MSGPACK-${JV_INSTALL_MSGPACK}" = 'INSTALL_MSGPACK-true' ] && { \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            _MSGPACK_VERSION='0.5.7'; \
        else \
            _MSGPACK_VERSION='3.0.0'; \
        fi; \
        pecl install msgpack-${_MSGPACK_VERSION}; \
        docker-php-ext-enable msgpack; \
    }; \
    \
    ## INSTALL THE PHP `igbinary` EXTENSION ########################################
    # With PHP 5.6 - using igbinary-2.0.8 version.
    # Links:
    #   https://pecl.php.net/package/igbinary (stable: 3.2.16 | Release: 2024-08-10)
    ################################################################################
    [ "INSTALL_IGBINARY-${JV_INSTALL_IGBINARY}" = 'INSTALL_IGBINARY-true' ] && { \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            _IGBINARY_VERSION='2.0.8'; \
        else \
            _IGBINARY_VERSION='3.2.16'; \
        fi; \
        pecl install igbinary-${_IGBINARY_VERSION}; \
        docker-php-ext-enable igbinary; \
    }; \
    \
    ## INSTALL THE PHP `gnupg` EXTENSION ###########################################
    # Requires:
    #   Packages: libgpgme-dev(libgpgme{xx})
    # Links:
    #   https://pecl.php.net/package/gnupg (stable: 1.5.1 | Release: 2021-12-31)
    ################################################################################
    [ "INSTALL_GNUPG-${JV_INSTALL_GNUPG}" = 'INSTALL_GNUPG-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libgpgme"; \
        apt-get install -yqq --no-install-recommends libgpgme-dev; \
        _GNUPG_VERSION='1.5.1'; \
        pecl install gnupg-${_GNUPG_VERSION}; \
        docker-php-ext-enable gnupg; \
    }; \
    \
    ## INSTALL THE PHP `yaml` EXTENSION ############################################
    # With PHP 5.6 - using yaml-1.3.2 version.
    #      PHP 7.0 - using yaml-2.0.4 version.
    # Requires:
    #   Packages: libyaml-dev(libyaml-{xx}-{yy})
    # Links:
    #   https://pecl.php.net/package/yaml (stable: 2.2.4 | Release: 2024-10-07)
    ################################################################################
    [ "INSTALL_YAML-${JV_INSTALL_YAML}" = 'INSTALL_YAML-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libyaml"; \
        apt-get install -yqq --no-install-recommends libyaml-dev; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            _YAML_VERSION='1.3.2'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ]; then \
            _YAML_VERSION='2.0.4'; \
        else \
            _YAML_VERSION='2.2.4'; \
        fi; \
        pecl install yaml-${_YAML_VERSION}; \
        docker-php-ext-enable yaml; \
    }; \
    \
    ## INSTALL THE PHP `xsl` EXTENSION #############################################
    # Requires:
    #   Packages:   libxslt1-dev(libxslt1.{xx})
    #   Extensions: libxml (default enabled)
    ################################################################################
    [ "INSTALL_XSL-${JV_INSTALL_XSL}" = 'INSTALL_XSL-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libxslt1"; \
        apt-get install -yqq --no-install-recommends libxslt1-dev; \
        docker-php-ext-configure xsl --with-xsl; \
        docker-php-ext-install -j$(nproc) xsl; \
    }; \
    \
    ## INSTALL THE PHP `xlswriter` EXTENSION #######################################
    # With PHP 5.x, this extension is not supported.
    # Links:
    #   https://pecl.php.net/package/xlswriter (stable: 1.5.8 | Release: 2024-11-10)
    ################################################################################
    [ "INSTALL_XLSWRITER-${JV_INSTALL_XLSWRITER}" = 'INSTALL_XLSWRITER-true' ] && { \
        [ ${_PHP_MAJOR_VERSION} -eq 5 ] && { echo 'ERROR: For PHP 5.x, the `xlswriter` extension is not supported!' >&2 && exit -1; }; \
        _XLSWRITER_VERSION='1.5.8'; \
        pecl install xlswriter-${_XLSWRITER_VERSION}; \
        docker-php-ext-enable xlswriter; \
    }; \
    \
    ## INSTALL THE PHP `opcache` EXTENSION #########################################
    [ "INSTALL_OPCACHE-${JV_INSTALL_OPCACHE}" = 'INSTALL_OPCACHE-true' ] && { \
        docker-php-ext-configure opcache --enable-opcache; \
        docker-php-ext-install -j$(nproc) opcache; \
    }; \
    \
    ## INSTALL THE PHP `memcached` EXTENSION #######################################
    # With PHP 5.6 - using memcached-2.2.0 version.
    # Requires:
    #   Packages:
    #     libmemcached-dev(libmemcachedutil{xx} libmemcached{xx})
    #     zlib1g-dev(zlib)
    #     libssl-dev(libssl{xx}.{yy} openssl libcrypto)
    #   Extensions:
    #     json session (default enabled)
    #     msgpack igbinary (manual installation)
    # Links:
    #   https://pecl.php.net/package/memcached (stable: 3.3.0 | Release: 2024-10-17)
    ################################################################################
    [ "INSTALL_MEMCACHED-${JV_INSTALL_MEMCACHED}" = 'INSTALL_MEMCACHED-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libmemcachedutil libmemcached"; \
        apt-get install -yqq --no-install-recommends libmemcached-dev; \
        # For Debian kernel is `bookworm`.
        [ ${_DEBIAN_MAJOR_RELEASE} -ge 12 ] && { \
            _MARK_PACKAGES="${_MARK_PACKAGES} zlib1g libssl openssl libcrypto"; \
            apt-get install -yqq --no-install-recommends zlib1g-dev libssl-dev; \
        }; \
        \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            _MEMCACHED_VERSION='2.2.0'; \
        else \
            _MEMCACHED_VERSION='3.3.0'; \
        fi; \
        pecl install --nobuild memcached-${_MEMCACHED_VERSION}; \
        \
        _MEMCACHED_CONFIG_ENABLE='--enable-memcached-json --enable-memcached-session'; \
        [ "INSTALL_MSGPACK-${JV_INSTALL_MSGPACK}" = 'INSTALL_MSGPACK-true' ] && { \
            _MEMCACHED_CONFIG_ENABLE="${_MEMCACHED_CONFIG_ENABLE} --enable-memcached-msgpack"; \
        }; \
        [ "INSTALL_IGBINARY-${JV_INSTALL_IGBINARY}" = 'INSTALL_IGBINARY-true' ] && { \
            _MEMCACHED_CONFIG_ENABLE="${_MEMCACHED_CONFIG_ENABLE} --enable-memcached-igbinary"; \
        }; \
        \
        _MEMCACHED_TEMP_DIR="${_PECL_CONFIG_TEMP_DIR}/memcached"; \
        docker-php-ext-configure ${_MEMCACHED_TEMP_DIR} ${_MEMCACHED_CONFIG_ENABLE}; \
        docker-php-ext-install -j$(nproc) ${_MEMCACHED_TEMP_DIR}; \
    }; \
    \
    ## INSTALL THE PHP `imap` EXTENSION ############################################
    # With PHP 8.3|8.4 - using imap-x.y.z version.
    # Requires:
    #   Packages:
    #     libc-client-dev(libc-client2007e)
    #     libkrb5-dev(krb5-multidev)
    #     libssl-dev(libssl{xx}.{yy} openssl libcrypto)
    # Links:
    #   https://pecl.php.net/package/imap (stable: 1.0.3 | Release: 2024-10-15)
    ################################################################################
    [ "INSTALL_IMAP-${JV_INSTALL_IMAP}" = 'INSTALL_IMAP-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libc-client libkrb5 krb5 libssl openssl libcrypto"; \
        apt-get install -yqq --no-install-recommends libc-client-dev libkrb5-dev libssl-dev; \
        if [ ${_PHP_MAJOR_VERSION} -le 7 ] || { [ ${_PHP_MAJOR_VERSION} -eq 8 ] && [ ${_PHP_MINOR_VERSION} -le 2 ]; }; then \
            _IMAP_TEMP_DIR='imap'; \
        else \
            _IMAP_TEMP_DIR="${_PECL_CONFIG_TEMP_DIR}/imap"; \
            \
            _IMAP_VERSION='1.0.3'; \
            pecl install --nobuild imap-${_IMAP_VERSION}; \
        fi; \
        docker-php-ext-configure ${_IMAP_TEMP_DIR} --with-kerberos --with-imap-ssl; \
        docker-php-ext-install -j$(nproc) ${_IMAP_TEMP_DIR}; \
    }; \
    \
    ## INSTALL THE PHP `ldap` EXTENSION ############################################
    # Requires:
    #   Packages: libldap2-dev(libldap-{xx}-{xx}) libsasl2-dev(libsasl2-{xx})
    ################################################################################
    [ "INSTALL_LDAP-${JV_INSTALL_LDAP}" = 'INSTALL_LDAP-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libldap libsasl2"; \
        apt-get install -yqq --no-install-recommends libldap2-dev libsasl2-dev; \
        \
        _LDAP_CONFIG_ENABLE='--with-ldap --with-ldap-sasl'; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ]; then \
            _LDAP_CONFIG_ENABLE="${_LDAP_CONFIG_ENABLE} --with-libdir=lib/${_DEB_BUILD_MULTIARCH}"; \
        fi; \
        \
        docker-php-ext-configure ldap ${_LDAP_CONFIG_ENABLE}; \
        docker-php-ext-install -j$(nproc) ldap; \
    }; \
    \
    ## INSTALL THE PHP `soap` EXTENSION ############################################
    # Requires:
    #   Packages:   libxml2-dev(libxml2)
    #   Extensions: libxml (default enabled)
    ################################################################################
    [ "INSTALL_SOAP-${JV_INSTALL_SOAP}" = 'INSTALL_SOAP-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libxml2"; \
        apt-get install -yqq --no-install-recommends libxml2-dev; \
        docker-php-ext-configure soap --enable-soap; \
        docker-php-ext-install -j$(nproc) soap; \
    }; \
    \
    ## INSTALL THE PHP `sockets` EXTENSION #########################################
    [ "INSTALL_SOCKETS-${JV_INSTALL_SOCKET}" = 'INSTALL_SOCKETS-true' ] && { \
        docker-php-ext-configure sockets --enable-sockets; \
        docker-php-ext-install -j$(nproc) sockets; \
    }; \
    \
    ## INSTALL THE PHP `ssh2` EXTENSION ############################################
    # With PHP 5.6 - using ssh2-0.13 version.
    # Requires:
    #   Packages: libssh2-1-dev (libssh2-1)
    # Links:
    #   https://pecl.php.net/package/ssh2 (stable: 1.4.1 | Release: 2024-02-10)
    ################################################################################
    [ "INSTALL_SSH2-${JV_INSTALL_SSH2}" = 'INSTALL_SSH2-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libssh2"; \
        apt-get install -yqq --no-install-recommends libssh2-1-dev; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            _SSH2_VERSION='0.13'; \
        else \
            _SSH2_VERSION='1.4.1'; \
        fi; \
        pecl install ssh2-${_SSH2_VERSION}; \
        docker-php-ext-enable ssh2; \
    }; \
    \
    ## INSTALL THE PHP `gd` EXTENSION ##############################################
    # Requires:
    #   Packages:
    #     libgd-dev(libgd{xx})
    #     libgd{xx}(libfontconfig1 libfreetype6 libjpeg62-turbo libpng16-16 libtiff5 libwebp6 libxpm4 zlib1g)
    #     libwebp-dev(libwebp{xx} libwebpmux{xx} libwebpdemux{xx})
    ################################################################################
    [ "INSTALL_GD-${JV_INSTALL_GD}" = 'INSTALL_GD-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libgd libwebp"; \
        apt-get install -yqq --no-install-recommends libgd-dev libwebp-dev; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ] || { [ ${_PHP_MAJOR_VERSION} -eq 7 ] && [ ${_PHP_MINOR_VERSION} -le 3 ]; }; then \
            docker-php-ext-configure gd --prefix=/usr --with-gd --with-jpeg-dir --with-png-dir --with-zlib-dir --with-freetype-dir --with-webp-dir --with-xpm-dir --enable-gd-jis-conv; \
        else \
            docker-php-ext-configure gd --prefix=/usr --enable-gd --with-jpeg --with-freetype --with-webp --with-xpm --enable-gd-jis-conv; \
        fi; \
        docker-php-ext-install -j$(nproc) gd; \
    }; \
    \
    ## INSTALL THE PHP `exif` EXTENSION ############################################
    # Requires:
    #   Packages:   libexif-dev(libexif{xx})
    #   Extensions: mbstring (default enabled)
    ################################################################################
    [ "INSTALL_EXIF-${JV_INSTALL_EXIF}" = 'INSTALL_EXIF-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libexif"; \
        apt-get install -yqq --no-install-recommends libexif-dev; \
        docker-php-ext-configure exif --enable-exif; \
        docker-php-ext-install -j$(nproc) exif; \
    }; \
    \
    ## INSTALL THE PHP `imagick` EXTENSION #########################################
    # Requires:
    #   Packages:
    #     libmagickwand-dev(libmagickwand-{xx}-... libmagickcore-{xx}-... imagemagick-{xx}-common)
    #     imagemagick(imagemagick-{xx}.{yy})
    # Links:
    #   https://pecl.php.net/package/imagick (stable: 3.7.0 | Release: 2022-01-11)
    ################################################################################
    [ "INSTALL_IMAGICK-${JV_INSTALL_IMAGICK}" = 'INSTALL_IMAGICK-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libmagickwand libmagickcore imagemagick"; \
        apt-get install -yqq --no-install-recommends libmagickwand-dev imagemagick; \
        _IMAGICK_VERSION='3.7.0'; \
        if [ ${_PHP_MAJOR_VERSION} -le 7 ] || { [ ${_PHP_MAJOR_VERSION} -eq 8 ] && [ ${_PHP_MINOR_VERSION} -le 2 ]; }; then \
            pecl install imagick-${_IMAGICK_VERSION}; \
        else \
            wget --no-check-certificate --progress=bar:force:noscroll "https://pecl.php.net/get/imagick-${_IMAGICK_VERSION}.tgz" --output-document='/tmp/imagick.tgz'; \
            mkdir -p /tmp/imagick; \
            tar -zx --file='/tmp/imagick.tgz' --directory='/tmp/imagick' --strip 1; \
            cd /tmp/imagick; \
            phpize && ./configure && make && make install; \
            cd ${_WORKDIR} && rm -rf /tmp/imagick; \
        fi; \
        docker-php-ext-enable imagick; \
    }; \
    \
    ## INSTALL THE PHP `mysql/mysqli/pdo_mysql` EXTENSIONS #########################
    # Requires:
    #   Packages:
    #     mariadb-client(mariadb-client-{xx}.{yy})
    #     default-mysql-client(default-mysql-client)
    #   Extensions:
    #     mysqlnd (default enabled)
    ################################################################################
    [ "INSTALL_MYSQLI/PDO_MYSQL-${JV_INSTALL_MYSQL}" = 'INSTALL_MYSQLI/PDO_MYSQL-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} mariadb-client default-mysql-client"; \
        apt-get install -yqq --no-install-recommends mariadb-client default-mysql-client; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            docker-php-ext-configure mysql --with-mysql=mysqlnd; \
            docker-php-ext-install -j$(nproc) mysql; \
        fi; \
        docker-php-ext-configure mysqli --with-mysqli=mysqlnd; \
        docker-php-ext-install -j$(nproc) mysqli; \
        docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd; \
        docker-php-ext-install -j$(nproc) pdo_mysql; \
    }; \
    \
    ## INSTALL THE PHP `pgsql/pdo_pgsql` EXTENSIONS ################################
    # Requires:
    #   Packages:   libpq-dev(libpq{xx})
    #   Extensions: pgsql (included installation)
    ################################################################################
    [ "INSTALL_PGSQL/PDO_PGSQL-${JV_INSTALL_PGSQL}" = 'INSTALL_PGSQL/PDO_PGSQL-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libpq"; \
        apt-get install -yqq --no-install-recommends libpq-dev; \
        docker-php-ext-configure pgsql --with-pgsql; \
        docker-php-ext-install -j$(nproc) pgsql; \
        docker-php-ext-configure pdo_pgsql --with-pdo-pgsql=pgsql; \
        docker-php-ext-install -j$(nproc) pdo_pgsql; \
    }; \
    \
    ## INSTALL THE PHP `mongodb` EXTENSION #########################################
    # With PHP 5.6 - using mongodb-1.7.5 version.
    #      PHP 7.0 - using mongodb-1.9.2 version.
    #      PHP 7.1 - using mongodb-1.11.1 version.
    #      PHP 7.2|7.3 - using mongodb-1.16.2 version.
    # Links:
    #   https://pecl.php.net/package/mongodb (stable: 1.20.1 | Release: 2024-11-27)
    ################################################################################
    [ "INSTALL_MONGODB-${JV_INSTALL_MONGODB}" = 'INSTALL_MONGODB-true' ] && { \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            _MONGODB_VERSION='1.7.5'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ]; then \
            _MONGODB_VERSION='1.9.2'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.1' ]; then \
            _MONGODB_VERSION='1.11.1'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.2' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.3' ]; then \
            _MONGODB_VERSION='1.16.2'; \
        else \
            _MONGODB_VERSION='1.20.1'; \
        fi; \
        pecl install mongodb-${_MONGODB_VERSION}; \
        docker-php-ext-enable mongodb; \
    }; \
    \
    ## INSTALL THE PHP `mssql/pdo_dblib` EXTENSIONS ################################
    # As of PHP 7, these extensions are not supported.
    # Requires:
    #   Packages: freetds-dev(libct{xx} libsybdb{xx}) libsybdb5(libsybdb5)
    ################################################################################
    [ "INSTALL_MSSQL/PDO_DBLIB-${JV_INSTALL_MSSQL}" = 'INSTALL_MSSQL/PDO_DBLIB-true' ] && { \
        [ ${_PHP_MAJOR_VERSION} -ge 7 ] && { echo 'ERROR: As of PHP 7.0, `mssql/pdo_dblib` extensions are not supported!' >&2 && exit -1; }; \
        _MARK_PACKAGES="${_MARK_PACKAGES} libct libsybdb"; \
        apt-get install -yqq --no-install-recommends freetds-dev; \
        docker-php-ext-configure mssql --with-libdir=lib/${_DEB_BUILD_MULTIARCH}; \
        docker-php-ext-install mssql; \
        docker-php-ext-configure pdo_dblib --with-libdir=lib/${_DEB_BUILD_MULTIARCH}; \
        docker-php-ext-install pdo_dblib; \
    }; \
    \
    ## INSTALL THE PHP `sqlsrv/pdo_sqlsrv` EXTENSIONS ##############################
    # For Debian <= 10 using `ARM` or `AARCH` architecture, the `msodbcsql18` package is not supported.
    # With PHP 5.x this extension is not supported.
    #      PHP 7.0 - using sqlsrv-5.3.0 / pdo_sqlsrv-5.3.0 version.
    #      PHP 7.1 - using sqlsrv-5.6.1 / pdo_sqlsrv-5.6.1 version.
    #      PHP 7.2 - using sqlsrv-5.8.1 / pdo_sqlsrv-5.8.1 version.
    #      PHP 7.3|7.4 - using sqlsrv-5.10.1 / pdo_sqlsrv-5.10.1 version.
    #      PHP 8.0 - using sqlsrv-5.11.1 / pdo_sqlsrv-5.11.1 version.
    # Requires:
    #   Packages:
    #     apt-transport-https(apt-transport-https)
    #     lsb-release(lsb-release)
    #     unixodbc-dev(libodbc{xx} odbcinst{xx}debian{yy} libltdl{xx})
    #     unixodbc(unixodbc)
    #     libgss3(libgss3)
    #     locales(locales)
    #     msodbcsql17(msodbcsql17)
    #   Extensions:
    #     sqlsrv (included installation)
    # Links:
    #   https://pecl.php.net/package/sqlsrv (stable: 5.12.0 | Release: 2024-01-31)
    #   https://pecl.php.net/package/pdo_sqlsrv
    ################################################################################
    [ "INSTALL_SQLSRV/PDO_SQLSRV-${JV_INSTALL_SQLSRV}" = 'INSTALL_SQLSRV/PDO_SQLSRV-true' ] && { \
        [ ${_PHP_MAJOR_VERSION} -eq 5 ] && { echo 'ERROR: For PHP 5.x, `sqlsrv/pdo_sqlsrv` extensions are not supported!' >&2 && exit -1; }; \
        [ ${_DEBIAN_MAJOR_RELEASE} -le 10 ] && [ "${_UNIX_IS_ARM}" = 'true' ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian ${_DEBIAN_MAJOR_RELEASE} kernel - architecture '${_UNIX_ARCHITECTURE}', package 'msodbcsql18' is not supported!" >&2 && exit -1; \
        }; \
        _MARK_PACKAGES="${_MARK_PACKAGES} apt-transport-https lsb-release"; \
        apt-get install -yqq --no-install-recommends apt-transport-https lsb-release; \
        _MARK_PACKAGES="${_MARK_PACKAGES} libodbc odbcinst libltdl unixodbc libgss3 locales"; \
        apt-get install -yqq --no-install-recommends unixodbc-dev unixodbc libgss3 locales; \
        \
        # Add Microsoft repo for Microsoft ODBC Driver 13 for Linux
        # Ref from https://github.com/Microsoft/msphpsql/wiki/Install-and-configuration#docker-files
        _SQLSRV_KEYRING='/usr/share/keyrings/microsoft-prod.gpg'; \
        _SQLSRV_KEYRING_ESCAPE=$(echo ${_SQLSRV_KEYRING} | sed 's/\//\\\//g'); \
        curl -kfSL https://packages.microsoft.com/keys/microsoft.asc | tee /etc/apt/trusted.gpg.d/microsoft.asc; \
        curl -kfSL https://packages.microsoft.com/config/debian/${_DEBIAN_MAJOR_RELEASE}/prod.list | sed 's/signed-by='${_SQLSRV_KEYRING_ESCAPE}'//g' | tee /etc/apt/sources.list.d/mssql-release.list; \
        apt-get update -yqq; \
        \
        # Fix Install msodbcsql17 if error when unixodbc and odbcinst is version {2.3.10}:
        if [ $(dpkg-query --showformat="\${Version}" --show odbcinst) = '2.3.10' ]; then \
            _UNIXODBC_REPO="https://packages.microsoft.com/debian/${_DEBIAN_MAJOR_RELEASE}/prod/pool/main/u/unixodbc"; \
            wget --no-check-certificate --progress=bar:force:noscroll "${_UNIXODBC_REPO}/libodbc1_2.3.7_amd64.deb" --output-document='/tmp/libodbc1.deb'; \
            wget --no-check-certificate --progress=bar:force:noscroll "${_UNIXODBC_REPO}/odbcinst1debian2_2.3.7_amd64.deb" --output-document='/tmp/odbcinst1debian2.deb';\
            wget --no-check-certificate --progress=bar:force:noscroll "${_UNIXODBC_REPO}/unixodbc_2.3.7_amd64.deb" --output-document='/tmp/unixodbc.deb'; \
            wget --no-check-certificate --progress=bar:force:noscroll "${_UNIXODBC_REPO}/odbcinst_2.3.7_amd64.deb" --output-document='/tmp/odbcinst.deb'; \
            wget --no-check-certificate --progress=bar:force:noscroll "${_UNIXODBC_REPO}/unixodbc-dev_2.3.7_amd64.deb" --output-document='/tmp/unixodbc-dev.deb'; \
            dpkg -i /tmp/libodbc1.deb /tmp/odbcinst1debian2.deb /tmp/unixodbc.deb /tmp/odbcinst.deb /tmp/unixodbc-dev.deb; \
        fi; \
        [ -f /usr/lib/${_DEB_BUILD_MULTIARCH}/libltdl.la ] || cp -p ${_CONF_TEMP_DIR}/deb_build_multiarch/libltdl.la /usr/lib/${_DEB_BUILD_MULTIARCH}/libltdl.la; \
        \
        _MARK_PACKAGES="${_MARK_PACKAGES} msodbcsql18 mssql-tools18"; \
        ACCEPT_EULA=Y apt-get install -yqq --no-install-recommends msodbcsql18; \
        # Optional: for bcp and sqlcmd.
        ACCEPT_EULA=Y apt-get install -yqq --no-install-recommends mssql-tools18; \
        \
        echo "en_US.UTF-8 UTF-8" > /etc/locale.gen; \
        ln -sfn /etc/locale.alias /usr/share/locale/locale.alias; \
        locale-gen; \
        \
        if [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ]; then \
            _SQLSRV_VERSION='5.3.0'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.1' ]; then \
            _SQLSRV_VERSION='5.6.1'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.2' ]; then \
            _SQLSRV_VERSION='5.8.1'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.3' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.4' ]; then \
            _SQLSRV_VERSION='5.10.1'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '8.0' ]; then \
            _SQLSRV_VERSION='5.11.1'; \
        else \
            _SQLSRV_VERSION='5.12.0'; \
        fi; \
        pecl install sqlsrv-${_SQLSRV_VERSION} pdo_sqlsrv-${_SQLSRV_VERSION}; \
        docker-php-ext-enable sqlsrv pdo_sqlsrv; \
    }; \
    \
    ## INSTALL THE PHP `oci8/pdo_oci` EXTENSIONS ###################################
    # With PHP 5 using `ARM` or `AARCH` architecture, the `oracle-instantclient` package is not supported.
    # With PHP 5.x - using oci8-2.0.12 version.
    #      PHP 7.x - using oci8-2.2.0 version.
    #      PHP 8.0 - using oci8-3.0.1 version.
    #      PHP 8.1 - using oci8-3.2.1 version.
    # With PHP 8.3|8.4 - using pdo_oci-x.y.z version.
    # Requires:
    #   Packages: libaio-dev(libaio{xx}) libnsl-dev(libnsl{xx})
    # Links:
    #   https://pecl.php.net/package/oci8 (stable: 3.4.0 | Release: 2024-07-24)
    #   https://pecl.php.net/package/pdo_oci (stable: 1.1.0 | Release: 2024-08-21)
    #   https://www.oracle.com/database/technologies/instant-client/linux-x86-64-downloads.html
    ################################################################################
    [ "INSTALL_ORACLE_OCI8-${JV_INSTALL_OCI8}" = 'INSTALL_ORACLE_OCI8-true' ] && { \
        [ ${_PHP_MAJOR_VERSION} -eq 5 ] && [ "${_UNIX_IS_ARM}" = 'true' ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian ${_DEBIAN_MAJOR_RELEASE} kernel - architecture '${_UNIX_ARCHITECTURE}', package 'oracle-instantclient' is not supported!" >&2 && exit -1; \
        }; \
        # Add link download.
        if [ "${_UNIX_IS_ARM}" = 'true' ]; then \
            if [ ${_DEBIAN_MAJOR_RELEASE} -eq 9 ]; then \
                _OIC_BASIC_MIRROR='https://download.oracle.com/otn_software/linux/instantclient/191000/instantclient-basic-linux.arm64-19.10.0.0.0dbru.zip'; \
                _OIC_SDK_MIRROR='https://download.oracle.com/otn_software/linux/instantclient/191000/instantclient-sdk-linux.arm64-19.10.0.0.0dbru.zip'; \
                _OIC_VERSION='19.10'; \
                _OIC_FOLDER='instantclient_19_10'; \
            else \
                _OIC_BASIC_MIRROR='https://download.oracle.com/otn_software/linux/instantclient/1924000/instantclient-basic-linux.arm64-19.24.0.0.0dbru.zip'; \
                _OIC_SDK_MIRROR='https://download.oracle.com/otn_software/linux/instantclient/1924000/instantclient-sdk-linux.arm64-19.24.0.0.0dbru.zip'; \
                _OIC_VERSION='19.24'; \
                _OIC_FOLDER='instantclient_19_24'; \
            fi; \
            _OIC_VERSION_FIRST='19.1'; \
            export OCI_VERSION=19; \
        else \
            if [ ${_DEBIAN_MAJOR_RELEASE} -eq 9 ]; then \
                if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
                    _OIC_BASIC_MIRROR='https://raw.githubusercontent.com/diogomascarenha/oracle-instantclient/master/instantclient-basic-linux.x64-12.2.0.1.0.zip'; \
                    _OIC_SDK_MIRROR='https://raw.githubusercontent.com/diogomascarenha/oracle-instantclient/master/instantclient-sdk-linux.x64-12.2.0.1.0.zip'; \
                    _OIC_VERSION='12.2'; \
                    _OIC_VERSION_FIRST='12.1'; \
                    _OIC_FOLDER='instantclient_12_2'; \
                    export OCI_VERSION=12; \
                else \
                    _OIC_BASIC_MIRROR='https://download.oracle.com/otn_software/linux/instantclient/1925000/instantclient-basic-linux.x64-19.25.0.0.0dbru.zip'; \
                    _OIC_SDK_MIRROR='https://download.oracle.com/otn_software/linux/instantclient/1925000/instantclient-sdk-linux.x64-19.25.0.0.0dbru.zip'; \
                    _OIC_VERSION='19.25'; \
                    _OIC_VERSION_FIRST='19.1'; \
                    _OIC_FOLDER='instantclient_19_25'; \
                    export OCI_VERSION=19; \
                fi; \
            elif [ ${_DEBIAN_MAJOR_RELEASE} -eq 10 ]; then \
                _OIC_BASIC_MIRROR='https://download.oracle.com/otn_software/linux/instantclient/2116000/instantclient-basic-linux.x64-21.16.0.0.0dbru.zip'; \
                _OIC_SDK_MIRROR='https://download.oracle.com/otn_software/linux/instantclient/2116000/instantclient-sdk-linux.x64-21.16.0.0.0dbru.zip'; \
                _OIC_VERSION='21.16'; \
                _OIC_VERSION_FIRST='21.1'; \
                _OIC_FOLDER='instantclient_21_16'; \
                export OCI_VERSION=21; \
            else \
                _OIC_BASIC_MIRROR='https://download.oracle.com/otn_software/linux/instantclient/2360000/instantclient-basic-linux.x64-23.6.0.24.10.zip'; \
                _OIC_SDK_MIRROR='https://download.oracle.com/otn_software/linux/instantclient/2360000/instantclient-sdk-linux.x64-23.6.0.24.10.zip'; \
                _OIC_VERSION='23.6'; \
                _OIC_VERSION_FIRST='23.1'; \
                _OIC_FOLDER='instantclient_23_6'; \
                export OCI_VERSION=23; \
            fi; \
        fi; \
        _OIC_PARENT_PATH='/opt/oracle'; \
        _OIC_PATH="${_OIC_PARENT_PATH}/${_OIC_FOLDER}"; \
        # Export ENVs.
        export LD_LIBRARY_PATH="${_OIC_PATH}:${LD_LIBRARY_PATH:-}"; \
        export OCI_HOME="${_OIC_PATH}"; \
        export OCI_LIB_DIR="${_OIC_PATH}"; \
        export OCI_INCLUDE_DIR="${_OIC_PATH}/sdk/include"; \
        \
        ## Install Oracle instant client.
        mkdir -p ${_OIC_PARENT_PATH}; \
        # STEP 1: Download the desired Instant Client ZIP files.
        wget --no-check-certificate --progress=bar:force:noscroll "${_OIC_BASIC_MIRROR}" --output-document='/tmp/instantclient-basic.zip'; \
        wget --no-check-certificate --progress=bar:force:noscroll "${_OIC_SDK_MIRROR}" --output-document='/tmp/instantclient-sdk.zip'; \
        # STEP 2: Unzip the packages into a single directory.
        unzip /tmp/instantclient-basic.zip -d ${_OIC_PARENT_PATH}; rm -rf "${_OIC_PARENT_PATH}/META-INF"; \
        unzip /tmp/instantclient-sdk.zip -d ${_OIC_PARENT_PATH}; rm -rf "${_OIC_PARENT_PATH}/META-INF"; \
        # STEP 3: Prior to version 18.3, create the appropriate links for the version of Instant Client.
        [ -f ${_OIC_PATH}/libclntsh.so ] || { ln -s ${_OIC_PATH}/libclntsh.so.${_OIC_VERSION_FIRST} ${_OIC_PATH}/libclntsh.so; }; \
        [ -f ${_OIC_PATH}/libclntshcore.so ] || { ln -s ${_OIC_PATH}/libclntshcore.so.${_OIC_VERSION_FIRST} ${_OIC_PATH}/libclntshcore.so; }; \
        [ -f ${_OIC_PATH}/libocci.so ] || { ln -s ${_OIC_PATH}/libocci.so.${_OIC_VERSION_FIRST} ${_OIC_PATH}/libocci.so; }; \
        # STEP 4: Install the operating system `libaio` package.
        _ORACLE_DEPS='libaio-dev'; \
        [ ${_DEBIAN_MAJOR_RELEASE} -ge 11 ] && { \
            _ORACLE_DEPS="${_ORACLE_DEPS} libnsl-dev"; \
        }; \
        _MARK_PACKAGES="${_MARK_PACKAGES} libaio libct libsybdb libnsl"; \
        apt-get install -yqq --no-install-recommends ${_ORACLE_DEPS}; \
        # STEP 5: If Instant Client is the only Oracle Software installed on this system then update the runtime link path.
        sh -c "echo ${_OIC_PATH} > /etc/ld.so.conf.d/oracle-instantclient.conf"; \
        # STEP 6: Update the Dynamic Linker Run-Time Bindings.
        ldconfig; \
        ## DONE.
        \
        # Install PHP `oci8` extension.
        _OCI_PRE_PATH="instantclient,${_OIC_PATH}"; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            _OCI8_VERSION='2.0.12'; \
        elif [ ${_PHP_MAJOR_VERSION} -eq 7 ]; then \
            _OCI8_VERSION='2.2.0'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '8.0' ]; then \
            _OCI8_VERSION='3.0.1'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '8.1' ]; then \
            _OCI8_VERSION='3.2.1'; \
        else \
            _OCI8_VERSION='3.4.0'; \
        fi; \
        echo "${_OCI_PRE_PATH}" | pecl install oci8-${_OCI8_VERSION}; \
        docker-php-ext-enable oci8; \
        \
        # Install PHP `pdo_oci` extension.
        if [ ${_PHP_MAJOR_VERSION} -le 7 ] || { [ ${_PHP_MAJOR_VERSION} -eq 8 ] && [ ${_PHP_MINOR_VERSION} -le 2 ]; }; then \
            _OCI_PDO_ENABLE="--with-pdo-oci=${_OCI_PRE_PATH},"; \
            if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
                _OCI_PDO_ENABLE="${_OCI_PDO_ENABLE}${_OIC_VERSION_FIRST}"; \
            else \
                _OCI_PDO_ENABLE="${_OCI_PDO_ENABLE}${_OIC_VERSION}"; \
            fi; \
            docker-php-ext-configure pdo_oci ${_OCI_PDO_ENABLE}; \
            docker-php-ext-install pdo_oci; \
        else \
            _PDO_OCI_VERSION='1.1.0'; \
            echo "${_OCI_PRE_PATH}" | pecl install pdo_oci-${_PDO_OCI_VERSION}; \
            docker-php-ext-enable pdo_oci; \
        fi; \
    }; \
    \
    ## INSTALL THE PHP `redis` EXTENSION ###########################################
    # With PHP 5.6 - using redis-4.3.0 version.
    #      PHP 7.0|7.1 - using redis-5.3.7 version.
    #      PHP 7.2|7.3 - using redis-6.0.2 version.
    # Requires:
    #   Packages:
    #     redis-tools(redis-tools)
    #   Extensions:
    #     session json (default enabled)
    #     msgpack igbinary (manual installation)
    # Links:
    #   https://pecl.php.net/package/redis (stable: 6.1.0 | Release: 2024-10-04)
    ################################################################################
    [ "INSTALL_REDIS-${JV_INSTALL_REDIS}" = 'INSTALL_REDIS-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} redis-tools"; \
        apt-get install -yqq --no-install-recommends redis-tools; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            _REDIS_VERSION='4.3.0'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.1' ]; then \
            _REDIS_VERSION='5.3.7'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.2' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.3' ]; then \
            _REDIS_VERSION='6.0.2'; \
        else \
            _REDIS_VERSION='6.1.0'; \
        fi; \
        pecl install --nobuild redis-${_REDIS_VERSION}; \
        \
        _REDIS_CONFIG_ENABLE="--enable-redis-json --enable-redis-session"; \
        [ "INSTALL_MSGPACK-${JV_INSTALL_MSGPACK}" = 'INSTALL_MSGPACK-true' ] && { \
            _REDIS_CONFIG_ENABLE="${_REDIS_CONFIG_ENABLE} --enable-redis-msgpack"; \
        }; \
        [ "INSTALL_IGBINARY-${JV_INSTALL_IGBINARY}" = 'INSTALL_IGBINARY-true' ] && { \
            _REDIS_CONFIG_ENABLE="${_REDIS_CONFIG_ENABLE} --enable-redis-igbinary"; \
        }; \
        \
        _REDIS_TEMP_DIR="${_PECL_CONFIG_TEMP_DIR}/redis"; \
        docker-php-ext-configure ${_REDIS_TEMP_DIR} ${_REDIS_CONFIG_ENABLE}; \
        docker-php-ext-install -j$(nproc) ${_REDIS_TEMP_DIR}; \
    }; \
    \
    ## INSTALL THE PHP `amqp` EXTENSION ############################################
    # With PHP 5.6|7.0-3 - using amqp-1.11.0 version.
    # Requires:
    #   Packages: librabbitmq-dev(librabbitmq{xx})
    # Links:
    #   https://pecl.php.net/package/amqp (stable: 2.1.2 | Release: 2024-01-22)
    ################################################################################
    [ "INSTALL_AMQP-${JV_INSTALL_AMQP}" = 'INSTALL_AMQP-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} librabbitmq"; \
        apt-get install -yqq --no-install-recommends librabbitmq-dev; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ] || { [ ${_PHP_MAJOR_VERSION} -eq 7 ] && [ ${_PHP_MINOR_VERSION} -le 3 ]; }; then \
            _AMQP_VERSION='1.11.0'; \
        else \
            _AMQP_VERSION='2.1.2'; \
        fi; \
        pecl install amqp-${_AMQP_VERSION}; \
        docker-php-ext-enable amqp; \
    }; \
    \
    ## INSTALL THE PHP `event` EXTENSION ###########################################
    # With PHP 5.x, this extension requires the `socket` extension to be included.
    # Requires:
    #   Packages:
    #     libevent-dev(libevent-{xx}-{yy} libevent-core-{xx}-{yy}
    #     libevent-extra-{xx}-{yy} libevent-openssl-{xx}-{yy} libevent-pthreads-{xx}-{yy})
    #     libssl-dev(libssl{xx}.{yy} openssl libcrypto)
    #   Extensions:
    #     openssl (default enabled)
    #     sockets xdebug (manual installation)
    # Links:
    #   https://pecl.php.net/package/event (stable: 3.1.4 | Release: 2024-07-16)
    ################################################################################
    [ "INSTALL_EVENT-${JV_INSTALL_EVENT}" = 'INSTALL_EVENT-true' ] && { \
        _MARK_PACKAGES="${_MARK_PACKAGES} libevent-pthreads libevent-openssl libevent-extra libevent-core libevent libssl openssl libcrypto"; \
        apt-get install -yqq --no-install-recommends libevent-dev libssl-dev; \
        \
        _EVENT_CONFIG_ENABLE="--with-event-core --with-event-extra --with-event-openssl --with-event-pthreads"; \
        if [ "INSTALL_SOCKETS-${JV_INSTALL_SOCKET}" = 'INSTALL_SOCKETS-true' ]; then \
            _EVENT_CONFIG_ENABLE="${_EVENT_CONFIG_ENABLE} --enable-event-sockets"; \
        else \
            [ ${_PHP_MAJOR_VERSION} -eq 5 ] && { \
                echo 'ERROR: For PHP 5.x, the `event` extension requires the `socket` extension to be included: `JV_INSTALL_SOCKET=true`!' >&2 && exit -1; \
            }; \
            _EVENT_CONFIG_ENABLE="${_EVENT_CONFIG_ENABLE} --disable-event-sockets"; \
        fi; \
        [ "INSTALL_XDEBUG-${JV_INSTALL_XDEBUG}" = 'INSTALL_XDEBUG-true' ] && { \
            _EVENT_CONFIG_ENABLE="${_EVENT_CONFIG_ENABLE} --enable-event-debug"; \
        }; \
        \
        _EVENT_VERSION='3.1.4'; \
        pecl install --nobuild event-${_EVENT_VERSION}; \
        _EVENT_TEMP_DIR="${_PECL_CONFIG_TEMP_DIR}/event"; \
        docker-php-ext-configure ${_EVENT_TEMP_DIR} ${_EVENT_CONFIG_ENABLE}; \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.1' ]; then \
            docker-php-ext-install -j$(nproc) ${_EVENT_TEMP_DIR}; \
            docker-php-ext-enable --ini-name zdocker-php-ext-event.ini event; \
        else \
            docker-php-ext-install -j$(nproc) --ini-name zdocker-php-ext-event.ini ${_EVENT_TEMP_DIR}; \
        fi; \
    }; \
    \
    ## INSTALL THE PHP `xdebug` EXTENSION ##########################################
    # With PHP 5.6 - using xdebug-2.5.5 version
    #      PHP 7.0 - using xdebug-2.9.0 version
    #      PHP 7.1 - using xdebug-2.9.8 version
    #      PHP 7.2-4 - using xdebug-3.1.6 version
    # Links:
    #   https://pecl.php.net/package/xdebug (stable: 3.4.0 | Release: 2024-11-28)
    ################################################################################
    [ "INSTALL_XDEBUG-${JV_INSTALL_XDEBUG}" = 'INSTALL_XDEBUG-true' ] && { \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            _XDEBUG_VERSION='2.5.5'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ]; then \
            _XDEBUG_VERSION='2.9.0'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.1' ]; then \
            _XDEBUG_VERSION='2.9.8'; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.2' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.3' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.4' ]; then \
            _XDEBUG_VERSION='3.1.6'; \
        else \
            _XDEBUG_VERSION='3.4.0'; \
        fi; \
        pecl install xdebug-${_XDEBUG_VERSION}; \
        docker-php-ext-enable xdebug; \
    }; \
    \
    ## INSTALL PHPUNIT #############################################################
    # With PHP 5.6 - using phpunit-5.phar version
    #      PHP 7.0 - using phpunit-6.phar version
    #      PHP 7.1 - using phpunit-7.phar version
    #      PHP 7.2 - using phpunit-8.phar version
    #      PHP 7.3-4|8.0 - using phpunit-9.phar version
    #      PHP 8.1 - using phpunit-10.phar version
    #      PHP 8.2-4 - using phpunit-11.phar version
    # Links:
    #   https://phpunit.de/supported-versions.html
    ################################################################################
    [ "INSTALL_PHPUNIT-${JV_INSTALL_PHPUNIT}" = 'INSTALL_PHPUNIT-true' ] && { \
        if [ ${_PHP_MAJOR_VERSION} -eq 5 ]; then \
            _PHPUNIT_VERSION=5; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.0' ]; then \
            _PHPUNIT_VERSION=6; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.1' ]; then \
            _PHPUNIT_VERSION=7; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.2' ]; then \
            _PHPUNIT_VERSION=8; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '7.3' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '7.4' ] || [ ${_PHP_MAJOR_MINOR_VERSION} = '8.0' ]; then \
            _PHPUNIT_VERSION=9; \
        elif [ ${_PHP_MAJOR_MINOR_VERSION} = '8.1' ]; then \
            _PHPUNIT_VERSION=10; \
        else \
            _PHPUNIT_VERSION=11; \
        fi; \
        wget --no-check-certificate --progress=bar:force:noscroll "https://phar.phpunit.de/phpunit-${_PHPUNIT_VERSION}.phar" --output-document='/usr/local/bin/phpunit'; \
        chmod +x /usr/local/bin/phpunit; \
        phpunit --version; \
    }; \
    \
    ## INSTALL COMPOSER ############################################################
    [ "INSTALL_COMPOSER-${JV_INSTALL_COMPOSER}" = 'INSTALL_COMPOSER-true' ] && { \
        curl -kfSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
        COMPOSER_ALLOW_SUPERUSER=1 composer --version; \
    }; \
    \
    ## INSTALL NODEJS ##############################################################
    # With Debian 9(stretch) kernel, NODEJS version >=18 is not supported.
    #      Debian 10(buster) kernel, NODEJS versions <=8 are no longer supported.
    #      Debian 11(bullseye) kernel, NODEJS versions <=10 are no longer supported.
    #      Debian 12(bookworm) kernel, NODEJS versions <=16 are no longer supported.
    # With NodeJs  8 - using npm@6 version.
    #      NodeJs 10 - using npm@7 version.
    #      NodeJs 12 - using npm@8 version.
    #      NodeJs 14 - using npm@9 version.
    #      NodeJs 16 - using npm@9 version.
    # Requires:
    #   Packages: nodejs npm lsb-release(lsb-release)
    # Links:
    #   https://www.npmjs.com/package/npm (latest: 10.9.2 | Release: 2024-12-04)
    ################################################################################
    [ "INSTALL_NODEJS-${JV_INSTALL_NODEJS}" = 'INSTALL_NODEJS-true' ] && { \
        [ ${_DEBIAN_MAJOR_RELEASE} -eq 9 ] && [ ${JV_NODEJS_VERSION} -ge 18 ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian 9(stretch) kernel, NODEJS version >=18 is not supported!" >&2 && exit -1; \
        }; \
        [ ${_DEBIAN_MAJOR_RELEASE} -eq 10 ] && [ ${JV_NODEJS_VERSION} -le 8 ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian 10(buster) kernel, NODEJS versions <=8 are no longer supported!" >&2 && exit -1; \
        }; \
        [ ${_DEBIAN_MAJOR_RELEASE} -eq 11 ] && [ ${JV_NODEJS_VERSION} -le 10 ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian 11(bullseye) kernel, NODEJS versions <=10 are no longer supported!" >&2 && exit -1; \
        }; \
        [ ${_DEBIAN_MAJOR_RELEASE} -eq 12 ] && [ ${JV_NODEJS_VERSION} -le 16 ] && { \
            echo "ERROR: For PHP-FPM ${_PHP_MAJOR_MINOR_VERSION} using Debian 12(bookworm) kernel, NODEJS versions <=16 are no longer supported!" >&2 && exit -1; \
        }; \
        \
        _MARK_PACKAGES="${_MARK_PACKAGES} lsb-release ca-certificates curl gnupg nodejs npm"; \
        # With NodeJS <= 14, follow the Old installation method.
        [ ${JV_NODEJS_VERSION} -le 14 ] && { \
            curl -kfSL https://deb.nodesource.com/setup_${JV_NODEJS_VERSION}.x | bash -; \
        }; \
        # With NodeJS >= 16, follow the New installation method.
        [ ${JV_NODEJS_VERSION} -ge 16 ] && { \
            # @link https://github.com/nodesource/distributions/wiki/How-to-migrate-to-the-new-repository
            # Install necessary packages for downloading and verifying new repository information.
            apt-get install -yqq ca-certificates curl gnupg; \
            # Download the new repository's GPG key and save it in the keyring directory.
            curl -kfSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /usr/share/keyrings/nodesource.gpg; \
            # Add the new repository's source list with its GPG key for package verification.
            echo "deb [signed-by=/usr/share/keyrings/nodesource.gpg] https://deb.nodesource.com/node_${JV_NODEJS_VERSION}.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list; \
            # Update local package index to recognize the new repository.
            apt-get update -yqq; \
        }; \
        # Install Node.js from the new repository.
        apt-get install -yqq nodejs; \
        \
        # Update npm latest.
        if [ ${JV_NODEJS_VERSION} -eq 8 ]; then \
            npm install --global npm@6; \
        elif [ ${JV_NODEJS_VERSION} -eq 10 ]; then \
            npm install --global npm@7; \
        elif [ ${JV_NODEJS_VERSION} -eq 12 ]; then \
            npm install --global npm@8; \
        elif [ ${JV_NODEJS_VERSION} -eq 14 ]; then \
            npm install --global npm@9; \
        elif [ ${JV_NODEJS_VERSION} -eq 16 ]; then \
            npm install --global npm@9; \
        else \
            npm install --global npm@10; \
        fi; \
        node --version; \
        npm --version; \
    }; \
    \
    ## INSTALL YARN ################################################################
    # YARN requires NODEJS to be included.
    # With NODEJS <= 12 -> Only YARN version ONE is supported.
    # Requires:
    #   Packages: nodejs npm
    # Links:
    #   https://www.npmjs.com/package/yarn (latest: 1.22.22 | Release: 2024-03-10)
    #   https://www.npmjs.com/package/corepack (latest: 0.30.0 | Release: 2024-11-23)
    #   https://github.com/yarnpkg/berry/releases (latest: 4.5.3 | Release: 2024-11-25)
    ################################################################################
    [ "INSTALL_YARN-${JV_INSTALL_YARN}" = 'INSTALL_YARN-true' ] && { \
        [ "INSTALL_NODEJS-${JV_INSTALL_NODEJS}" != 'INSTALL_NODEJS-true' ] && { \
            echo 'ERROR: YARN requires NODEJS to be included: `JV_INSTALL_NODEJS=true`!' >&2 && exit -1; \
        }; \
        if [ "YARN_VERSION_ONE-${JV_YARN_VERSION_ONE}" = 'YARN_VERSION_ONE-true' ]; then \
            npm install --global yarn@1.22.22; \
        else \
            if [ ${JV_NODEJS_VERSION} -le 12 ]; then \
                npm install --global yarn@1.22.22; \
            else \
                if [ ${JV_NODEJS_VERSION} -eq 14 ]; then \
                    npm install --global corepack@0.17.2; \
                elif [ ${JV_NODEJS_VERSION} -ge 16 ]; then \
                    corepack enable; \
                else \
                    npm install --global corepack@0.30.0; \
                fi; \
                corepack prepare yarn@stable --activate; \
            fi; \
        fi; \
        yarn --version; \
    }; \
    \
    ## INSTALL BOWER ###############################################################
    # BOWER requires NODEJS to be included.
    # Requires:
    #   Packages: nodejs npm
    # Links:
    #   https://www.npmjs.com/package/bower (latest: 1.8.14 | Release: 2021-03-14)
    ################################################################################
    [ "INSTALL_BOWER-${JV_INSTALL_BOWER}" = 'INSTALL_BOWER-true' ] && { \
        [ "INSTALL_NODEJS-${JV_INSTALL_NODEJS}" != 'INSTALL_NODEJS-true' ] && { \
            echo 'ERROR: BOWER requires NODEJS to be included: `JV_INSTALL_NODEJS=true`!' >&2 && exit -1; \
        }; \
        npm install --global bower@1.8.14; \
        bower --version; \
    }; \
    \
    ## INSTALL SASS ################################################################
    # SASS requires NODEJS to be included.
    # With NodeJs <= 10 - using sass@1.49.0 version.
    #      NodeJs == 12 - using sass@1.60.0 version.
    # Requires:
    #   Packages: nodejs npm
    # Links:
    #   https://www.npmjs.com/package/sass (latest: 1.82.0 | Release: 2024-12-03)
    ################################################################################
    [ "INSTALL_SASS-${JV_INSTALL_SASS}" = 'INSTALL_SASS-true' ] && { \
        [ "INSTALL_NODEJS-${JV_INSTALL_NODEJS}" != 'INSTALL_NODEJS-true' ] && { \
            echo 'ERROR: SASS requires NODEJS to be included: `JV_INSTALL_NODEJS=true`!' >&2 && exit -1; \
        }; \
        if [ ${JV_NODEJS_VERSION} -le 10 ]; then \
            npm install --global sass@1.49.0; \
        elif [ ${JV_NODEJS_VERSION} -eq 12 ]; then \
            npm install --global sass@1.60.0; \
        else \
            npm install --global sass@1.82.0; \
        fi; \
        sass --version; \
    }; \
    \
    ## CLEANUP: BUILD DEPS AND CACHE ###############################################
    [ 'CLEANUP_EVERYTHING' = 'CLEANUP_EVERYTHING' ] && { \
        # Remove All manual package suffix is (-dev | .dev | -doc | .doc).
        _MARK_PACKAGES="$(echo ${_MARK_PACKAGES:-everything} | sed 's/^[^[:alnum:]]\+//g' | sed 's/[^[:alnum:]]\+$//g' | sed 's/ /\\|/g')"; \
        _MARK_MANUAL_SAVE="$(apt list --installed \
            | awk -F'/' 'NR>0{print $1}' \
            | grep "^\(${_MARK_PACKAGES:-everything}\)" \
            | grep '.*\(\([^v]\)\|\([^e]v\)\|\([^d]ev\)\|\([^-]dev\)\)$' \
            | grep '.*\(\([^c]\)\|\([^o]c\)\|\([^d]oc\)\|\([^-]doc\)\)$' \
            | sort -u \
            | sed ':a;N;$!ba;s/\n/ /g')"; \
        # Reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies.
        apt-mark auto '.*' > /dev/null; \
        _MARK_APT_SAVED="${_MARK_APT_SAVED:-} ${_MARK_MANUAL_SAVE:-}"; \
        [ -n "${_MARK_APT_SAVED}" ] && { apt-mark manual ${_MARK_APT_SAVED} > /dev/null; }; \
        find /usr/local -type f -executable -exec ldd '{}' ';' \
            | awk '/=>/ {print $(NF-1)}' \
            | sort -u \
            | xargs -r dpkg-query --search \
            | cut -d: -f1 \
            | sort -u \
            | xargs -r apt-mark manual > /dev/null; \
        # Clear cache and logs.
        rm -rf /tmp/* /var/tmp/* \
            /var/cache/apt/* /var/lib/apt/lists/* \
            /var/log/lastlog /var/log/faillog \
            /tmp/pear ~/.pearrc; \
        apt-get clean; \
        apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
    }; \
    echo 'INFO: PHP EXTENSIONS INSTALLATION COMPLETED.' >&1;

# Change default shell for root user: ash -> bash.
RUN sed -i "s|root:/bin/ash|root:/bin/bash|i" /etc/passwd;
