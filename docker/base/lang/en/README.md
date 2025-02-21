# DOCKER BASE IMAGE

Build from `php:{x.y}-fpm` Docker Image.

## #List of ENVs declared

| ENVs                      |                                                              |
|:--------------------------|:-------------------------------------------------------------|
| `PHP_VERSION`             | Full PHP version (x.y.z).                                    |
| `PHPIZE_DEPS`             | List of dependent packages required to run `phpize`.         |
| `PHP_INI_DIR`             | Configuration directory path for PHP (`/usr/local/etc/php`). |
| `FPM_CONF_DIR`            | Configuration directory path for PHP-FPM (`/usr/local/etc`). |
| `DEBIAN_FRONTEND`         | `noninteractive` - Non-interactive mode in Console.          |
| `PHP_MAJOR_MINOR_VERSION` | PHP MAJOR.MINOR version (x.y).                               |

## #Installed Packages (Linux packages)

### #INCLUDED in the docker image `php:{x.y}-fpm`

| Packages        | Notes                                                                                                                                                                            |
|:----------------|:---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| bash            | Bash (Bourne Again Shell) is the free and enhanced version of the Bourne shell distributed with Linux and GNU operating systems.                                                 |
| ca-certificates | A CA certificate is a digital certificate issued by a certificate authority (CA), so SSL clients can use it to verify the SSL certificates sign by this CA.                      |
| curl            | cURL is a CLI tool that allows you to request and transfer data over a URL under different protocols.                                                                            |
| openssl         | OpenSSL is an open-source command line tool that is commonly used to generate private keys, create CSRs, install your SSL/TLS certificate, and identify certificate information. |
| tzdata          | The tzdata package contains the data files documenting both current and historic transitions for various time zones around the world.                                            |

### #More installed

| Packages            | Notes                                                                                                                                         |
|:--------------------|:----------------------------------------------------------------------------------------------------------------------------------------------|
| apt-utils           | The apt-utils package is a collection of utilities that are used to manage the Advanced Packaging Tool (APT) system in Linux.                 |
| apt-transport-https | APT transport for downloading via the HTTP Secure protocol (HTTPS).                                                                           |
| lsb-release         | The lsb-release command is a simple tool to help identify the Linux. distribution being used and its compliance with the Linux Standard Base. |
| wget                | GNU Wget is a command-line utility for downloading files from the web.                                                                        |
| gnupg               | GnuPG 1.4 is GNU's tool for secure communication and data storage. It can be used to encrypt data and to create digital signatures.           |
| gnupg2              | GnuPG 2.0 is a newer version of GnuPG with additional support for S/MIME.                                                                     |
| zip                 | The zip command is a command-line tool in Linux that allows us to create an archive of files and directories.                                 |
| unzip               | Unzip is a utility that helps you list, test, and extract compressed ZIP archives.                                                            |
| git                 | GIT is the most versatile distributed version control system.                                                                                 | 

## #Source code managers are supported

| Name     | Notes                                                                            | HomePage                                   | To install                                                                       |
|:---------|:---------------------------------------------------------------------------------|:-------------------------------------------|:---------------------------------------------------------------------------------|
| composer | Composer is a tool for dependency management in PHP.                             | [getcomposer.org](https://getcomposer.org) | `JV_INSTALL_COMPOSER=true`                                                       |
| node/npm | NPM is a package manager for Node.js packages, or modules if you like.           | [nodejs.org](https://nodejs.org)           | `JV_INSTALL_NODEJS=true`<br/>_Requires a NodeJS version:_ `JV_NODEJS_VERSION=xx` |
| yarn     | Yarn is a new package manager for JavaScript.                                    | [yarnpkg.com](https://yarnpkg.com)         | `JV_INSTALL_YARN=true`<br/>_Requires NodeJS included:_ `JV_INSTALL_NODEJS=true`  |
| bower    | Bower can manage components that contain HTML, CSS, JavaScript, Fonts or Images. | [bower.io](https://bower.io)               | `JV_INSTALL_BOWER=true`<br/>_Requires NodeJS included:_ `JV_INSTALL_NODEJS=true` |
| sass     | SASS is a CSS preprocessor, is a scripting language that extends CSS.            | [sass-lang.com](https://sass-lang.com)     | `JV_INSTALL_SASS=true`<br/>_Requires NodeJS included:_ `JV_INSTALL_NODEJS=true`  |

**🔥IMPORTANT: Support for NodeJS with OS versions of PHP builds:**

> Supported with PHP build:
> - ✅ : Supported.
> - ❌ : Unsupported.

_NPM Version at the time: `latest = 10.x.y` ._

<!-- https://github.com/nodesource/distributions/blob/master/README.md -->

| PHP version  | PHP 8.4  | PHP 8.4  | PHP 8.3  | PHP 8.3  | PHP 8.2  | PHP 8.2  | PHP 8.1  | PHP 8.1  | NPM Support | To install             |
|:-------------|:--------:|:--------:|:--------:|:--------:|:--------:|:--------:|:--------:|:--------:|:-----------:|:-----------------------|
| Distribution | Bookworm | Bullseye | Bookworm | Bullseye | Bookworm | Bullseye | Bookworm | Bullseye | ----------- | ---------------------- |
| Debian OS    |    12    |    11    |    12    |    11    |    12    |    11    |    12    |    11    | ----------- | ---------------------- |
| ------------ | -------- | -------- | -------- | -------- | -------- | -------- | -------- | -------- | ----------- | ---------------------- |
| NodeJS 18    |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=18` |
| NodeJS 20    |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=20` |
| NodeJS 21    |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=21` |
| NodeJS 22    |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=22` |
| NodeJS 23    |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=23` |

## #PHPUnit is supported

<!-- https://phpunit.de/supported-versions.html -->

| PHP version     | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | To install                |
|:----------------|:-------:|:-------:|:-------:|:-------:|:--------------------------|
| PHPUnit version |   11    |   11    |   11    |   10    | `JV_INSTALL_PHPUNIT=true` |

## #Install PHP Extensions

> Supported with PHP version:
> - ✅ : Supported.
> - ❌ : Unsupported.

### #INCLUDED in the docker image `php:{x.y}-fpm`

<!-- View detail: https://github.com/mlocati/docker-php-extension-installer/blob/master/README.md#supported-php-extensions -->
<!-- Link icon: https://emojipedia.org/unicode-6.0 -->

> ➕ : Supported (Not available in `php:{x.y}-fpm` - But installed by default).

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Name                                                                            |
|:-----------|:-------:|:-------:|:-------:|:-------:|:--------------------------------------------------------------------------------|
| Core       |    ✅    |    ✅    |    ✅    |    ✅    | [PHP Core](https://www.php.net/manual/en/funcref.php)                           |
| ctype      |    ✅    |    ✅    |    ✅    |    ✅    | [Character type checking](https://www.php.net/manual/en/book.ctype.php)         |
| curl       |    ✅    |    ✅    |    ✅    |    ✅    | [Client URL Library](https://www.php.net/manual/en/book.curl.php)               |
| date       |    ✅    |    ✅    |    ✅    |    ✅    | [Date and Time Related](https://www.php.net/manual/en/refs.calendar.php)        |
| dom        |    ✅    |    ✅    |    ✅    |    ✅    | [Document Object Model](https://www.php.net/manual/en/book.dom.php)             |
| fileinfo   |    ✅    |    ✅    |    ✅    |    ✅    | [File Information](https://www.php.net/manual/en/book.fileinfo.php)             |
| filter     |    ✅    |    ✅    |    ✅    |    ✅    | [Data Filtering](https://www.php.net/manual/en/book.filter.php)                 |
| ftp        |    ➕    |    ➕    |    ➕    |    ✅    | [File Transfer Protocol](https://www.php.net/manual/en/book.ftp.php)            |
| hash       |    ✅    |    ✅    |    ✅    |    ✅    | [HASH Message Digest Framework](https://www.php.net/manual/en/book.hash.php)    |
| iconv      |    ✅    |    ✅    |    ✅    |    ✅    | [Internationalization Conversion](https://www.php.net/manual/en/book.iconv.php) |
| json       |    ✅    |    ✅    |    ✅    |    ✅    | [JavaScript Object Notation](https://www.php.net/manual/en/book.json.php)       |
| libxml     |    ✅    |    ✅    |    ✅    |    ✅    | [Lib XML](https://www.php.net/manual/en/book.libxml.php)                        |
| mbstring   |    ✅    |    ✅    |    ✅    |    ✅    | [Multibyte String](https://www.php.net/manual/en/book.mbstring.php)             |
| mysqlnd    |    ✅    |    ✅    |    ✅    |    ✅    | [MySQL Native Driver](https://www.php.net/manual/en/book.mysqlnd.php)           |
| openssl    |    ✅    |    ✅    |    ✅    |    ✅    | [OpenSSL](https://www.php.net/manual/en/book.openssl.php)                       |
| pcre       |    ✅    |    ✅    |    ✅    |    ✅    | [Regular Expression](https://www.php.net/manual/en/book.pcre.php)               |
| PDO        |    ✅    |    ✅    |    ✅    |    ✅    | [PHP Data Objects](https://www.php.net/manual/en/book.pdo.php)                  |
| pdo_sqlite |    ✅    |    ✅    |    ✅    |    ✅    | [SQLite Functions](https://www.php.net/manual/en/ref.pdo-sqlite.php)            |
| Phar       |    ✅    |    ✅    |    ✅    |    ✅    | [PHP Archive](https://www.php.net/manual/en/book.phar.php)                      |
| posix      |    ✅    |    ✅    |    ✅    |    ✅    | [Process Control Extension](https://www.php.net/manual/en/book.posix.php)       |
| random     |    ✅    |    ✅    |    ✅    |    ❌    | [Random Generators](https://www.php.net/manual/en/book.random.php)              |
| readline   |    ✅    |    ✅    |    ✅    |    ✅    | [GNU Readline](https://www.php.net/manual/en/book.readline.php)                 |
| Reflection |    ✅    |    ✅    |    ✅    |    ✅    | [Reflection Extension](https://www.php.net/manual/en/book.reflection.php)       |
| session    |    ✅    |    ✅    |    ✅    |    ✅    | [Session Handling](https://www.php.net/manual/en/book.session.php)              |
| SimpleXML  |    ✅    |    ✅    |    ✅    |    ✅    | [SimpleXML](https://www.php.net/manual/en/book.simplexml.php)                   |
| sodium     |    ✅    |    ✅    |    ✅    |    ✅    | [Sodium](https://www.php.net/manual/en/book.sodium.php)                         |
| SPL        |    ✅    |    ✅    |    ✅    |    ✅    | [Standard PHP Library](https://www.php.net/manual/en/book.spl.php)              |
| sqlite3    |    ✅    |    ✅    |    ✅    |    ✅    | [SQLite3](https://www.php.net/manual/en/book.sqlite3.php)                       |
| standard   |    ✅    |    ✅    |    ✅    |    ✅    | [PHP Standard](https://www.php.net/manual/en/extensions.php)                    |
| tokenizer  |    ✅    |    ✅    |    ✅    |    ✅    | [Tokenizer](https://www.php.net/manual/en/book.tokenizer.php)                   |
| xml        |    ✅    |    ✅    |    ✅    |    ✅    | [XML Parser](https://www.php.net/manual/en/book.xml.php)                        |
| xmlreader  |    ✅    |    ✅    |    ✅    |    ✅    | [XMLReader](https://www.php.net/manual/en/book.xmlreader.php)                   |
| xmlwriter  |    ✅    |    ✅    |    ✅    |    ✅    | [XMLWriter](https://www.php.net/manual/en/book.xmlwriter.php)                   |
| zlib       |    ✅    |    ✅    |    ✅    |    ✅    | [Zlib Compression](https://www.php.net/manual/en/book.zlib.php)                 |

### #Other extensions are supported

- Database Extensions:

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Name                                                                                       | To install                |
|:-----------|:-------:|:-------:|:-------:|:-------:|:-------------------------------------------------------------------------------------------|:--------------------------|
| mysql      |    ❌    |    ❌    |    ❌    |    ❌    | [Original MySQL API](https://www.php.net/manual/en/book.mysql.php)                         | `JV_INSTALL_MYSQL=true`   |
| mysqli     |    ✅    |    ✅    |    ✅    |    ✅    | [MySQL Improved Extension](https://www.php.net/manual/en/book.mysqli.php)                  | `JV_INSTALL_MYSQL=true`   |
| pdo_mysql  |    ✅    |    ✅    |    ✅    |    ✅    | [MySQL Functions (PDO_MYSQL)](https://www.php.net/manual/en/ref.pdo-mysql.php)             | `JV_INSTALL_MYSQL=true`   |
| mongodb    |    ✅    |    ✅    |    ✅    |    ✅    | [MongoDB Driver](https://www.php.net/manual/en/set.mongodb.php)                            | `JV_INSTALL_MONGODB=true` |
| pgsql      |    ✅    |    ✅    |    ✅    |    ✅    | [PostgreSQL Driver](https://www.php.net/manual/en/book.pgsql.php)                          | `JV_INSTALL_PGSQL=true`   |
| pdo_pgsql  |    ✅    |    ✅    |    ✅    |    ✅    | [PostgreSQL Functions (PDO_PGSQL)](https://www.php.net/manual/en/ref.pdo-pgsql.php)        | `JV_INSTALL_PGSQL=true`   |
| mssql      |    ❌    |    ❌    |    ❌    |    ❌    | [Microsoft SQL](https://www.php.net/manual/en/ref.pdo-dblib.php)                           | `JV_INSTALL_MSSQL=true`   |
| sqlsrv     |    ✅    |    ✅    |    ✅    |    ✅    | [Microsoft SQL Server Driver](https://www.php.net/manual/en/book.sqlsrv.php)               | `JV_INSTALL_SQLSRV=true`  |
| pdo_sqlsrv |    ✅    |    ✅    |    ✅    |    ✅    | [Microsoft SQL Server Functions](https://www.php.net/manual/en/ref.pdo-sqlsrv.php)         | `JV_INSTALL_SQLSRV=true`  |
| redis      |    ✅    |    ✅    |    ✅    |    ✅    | [PHP Redis extension](https://pecl.php.net/package/redis)                                  | `JV_INSTALL_REDIS=true`   |
| amqp       |    ✅    |    ✅    |    ✅    |    ✅    | [PHP AMQP extension](https://pecl.php.net/package/amqp)                                    | `JV_INSTALL_AMQP=true`    |
| oci8       |    ✅    |    ✅    |    ✅    |    ✅    | [Oracle OCI8](https://www.php.net/manual/en/book.oci8.php)                                 | `JV_INSTALL_OCI8=true`    |
| PDO_OCI    |    ✅    |    ✅    |    ✅    |    ✅    | [Oracle Functions](https://www.php.net/manual/en/ref.pdo-oci.php)                          | `JV_INSTALL_OCI8=true`    |
| pdo_dblib  |    ✅    |    ✅    |    ✅    |    ✅    | [Microsoft SQL Server and Sybase Functions](https://www.php.net/manual/en/ref.pdo-oci.php) | `JV_INSTALL_MSSQL=true`   |

- Image Extensions:

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Name                                                                          | To install                |
|:-----------|:-------:|:-------:|:-------:|:-------:|:------------------------------------------------------------------------------|:--------------------------|
| exif       |    ✅    |    ✅    |    ✅    |    ✅    | [Exchangeable image information](https://www.php.net/manual/en/book.exif.php) | `JV_INSTALL_EXIF=true`    |
| gd         |    ✅    |    ✅    |    ✅    |    ✅    | [Image Processing and GD](https://www.php.net/manual/en/book.image.php)       | `JV_INSTALL_GD=true`      |
| imagick    |    ✅    |    ✅    |    ✅    |    ✅    | [Image Processing](https://www.php.net/manual/en/book.imagick.php)            | `JV_INSTALL_IMAGICK=true` |

- Cryptography Extensions:

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Name                                                              | To install                 |
|:-----------|:-------:|:-------:|:-------:|:-------:|:------------------------------------------------------------------|:---------------------------|
| gnupg      |    ✅    |    ✅    |    ✅    |    ✅    | [GNU Privacy Guard](https://www.php.net/manual/en/book.gnupg.php) | `JV_INSTALL_GNUPG=true`    |
| igbinary   |    ✅    |    ✅    |    ✅    |    ✅    | [Igbinary](https://www.php.net/manual/en/book.igbinary.php)       | `JV_INSTALL_IGBINARY=true` |
| mcrypt     |    ❌    |    ✅    |    ✅    |    ✅    | [Mcrypt](https://www.php.net/manual/en/book.mcrypt.php)           | `JV_INSTALL_MCRYPT=true`   |
| msgpack    |    ✅    |    ✅    |    ✅    |    ✅    | [MsgPack](https://pecl.php.net/package/msgpack)                   | `JV_INSTALL_MSGPACK=true`  |

- Protocol Extensions:

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Name                                                                                 | To install               | Requires other Extensions |
|:-----------|:-------:|:-------:|:-------:|:-------:|:-------------------------------------------------------------------------------------|:-------------------------|:--------------------------|
| imap       |    ✅    |    ✅    |    ✅    |    ✅    | [IMAP, POP3 and NNTP](https://www.php.net/manual/en/book.imap.php)                   | `JV_INSTALL_IMAP=true`   |                           |
| ldap       |    ✅    |    ✅    |    ✅    |    ✅    | [Lightweight Directory Access Protocol](https://www.php.net/manual/en/book.ldap.php) | `JV_INSTALL_LDAP=true`   |                           |
| soap       |    ✅    |    ✅    |    ✅    |    ✅    | [SOAP](https://www.php.net/manual/en/book.soap.php)                                  | `JV_INSTALL_SOAP=true`   | `libxml`                  |
| sockets    |    ✅    |    ✅    |    ✅    |    ✅    | [Sockets](https://www.php.net/manual/en/book.sockets.php)                            | `JV_INSTALL_SOCKET=true` |                           |
| ssh2       |    ✅    |    ✅    |    ✅    |    ✅    | [Secure Shell2](https://www.php.net/manual/en/book.ssh2.php)                         | `JV_INSTALL_SSH2=true`   |                           |

- Other Extensions:

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Name                                                                                | To install                  | Requires other Extensions |
|:-----------|:-------:|:-------:|:-------:|:-------:|:------------------------------------------------------------------------------------|:----------------------------|:--------------------------|
| bcmath     |    ✅    |    ✅    |    ✅    |    ✅    | [BCMath Arbitrary Precision Mathematics](https://www.php.net/manual/en/book.bc.php) | `JV_INSTALL_BCMATH=true`    |                           |
| bz2        |    ✅    |    ✅    |    ✅    |    ✅    | [Bzip2](https://www.php.net/manual/en/book.bzip2.php)                               | `JV_INSTALL_BZ2=true`       |                           |
| calendar   |    ✅    |    ✅    |    ✅    |    ✅    | [Calendar](https://www.php.net/manual/en/book.calendar.php)                         | `JV_INSTALL_CALENDAR=true`  |                           |
| decimal    |    ✅    |    ✅    |    ✅    |    ✅    | [Arbitrary precision floating-point decimal](https://pecl.php.net/package/decimal)  | `JV_INSTALL_DECIMAL=true`   |                           |
| event      |    ✅    |    ✅    |    ✅    |    ✅    | [Event](https://www.php.net/manual/en/book.event.php)                               | `JV_INSTALL_EVENT=true`     | `openssl sockets`         |
| intl       |    ✅    |    ✅    |    ✅    |    ✅    | [Internationalization Functions](https://www.php.net/manual/en/book.intl.php)       | `JV_INSTALL_INTL=true`      |                           |
| memcached  |    ✅    |    ✅    |    ✅    |    ✅    | [Memcached](https://www.php.net/manual/en/book.memcached.php)                       | `JV_INSTALL_MEMCACHED=true` | `json session igbinary`   |
| opcache    |    ✅    |    ✅    |    ✅    |    ✅    | [Zend OPcache](https://www.php.net/manual/en/book.opcache.php)                      | `JV_INSTALL_OPCACHE=true`   |                           |
| pcntl      |    ✅    |    ✅    |    ✅    |    ✅    | [Process Control](https://www.php.net/manual/en/book.pcntl.php)                     | `JV_INSTALL_PCNTL=true`     |                           |
| xdebug     |    ✅    |    ✅    |    ✅    |    ✅    | [Xdebug](https://pecl.php.net/package/xdebug)                                       | `JV_INSTALL_XDEBUG=true`    |                           |
| xlswriter  |    ✅    |    ✅    |    ✅    |    ✅    | [XLSWriter](https://pecl.php.net/package/xlswriter)                                 | `JV_INSTALL_XLSWRITER=true` |                           |
| xsl        |    ✅    |    ✅    |    ✅    |    ✅    | [XSL implements the XSL standard](https://www.php.net/manual/en/book.xsl.php)       | `JV_INSTALL_XSL=true`       |                           |
| yaml       |    ✅    |    ✅    |    ✅    |    ✅    | [YAML Data Serialization](https://www.php.net/manual/en/book.yaml.php)              | `JV_INSTALL_YAML=true`      |                           |
| zip        |    ✅    |    ✅    |    ✅    |    ✅    | [ZIP](https://www.php.net/manual/en/book.zip.php)                                   | `JV_INSTALL_ZIP=true`       |                           |

> **Reference:**
> - Database Extensions: [Link](https://www.php.net/manual/en/refs.database.php)
> - PDO Driver Extensions: [Link](https://www.php.net/manual/en/pdo.drivers.php)
> - PHP Function Reference: [Link](https://www.php.net/manual/en/funcref.php)
> - Oracle Instant Client Downloads for Linux: [Link](https://www.oracle.com/database/technologies/instant-client/linux-x86-64-downloads.html)
> - Supported PHP extensions: [Link](https://github.com/mlocati/docker-php-extension-installer/blob/master/README.md#supported-php-extensions)

## #Already Configured

- `/usr/local/etc/php/` : PHP settings folder (`php.ini` file).
- `/usr/local/etc/php/conf.d/` : PHP custom settings folder.
- `/usr/local/etc/` : PHP-FPM settings folder (`php-fpm.conf` file).
- `/usr/local/etc/php-fpm.d/` : PHP-FPM custom settings folder.
- `/var/log/php` : PHP/PHP-FPM log folder.
