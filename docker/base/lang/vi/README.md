# DOCKER BASE IMAGE

Được xây dựng từ hình ảnh docker `php:{x.y}-fpm`.

## #Danh sách ENV đã khai báo

| ENVs                      |                                                              |
|:--------------------------|:-------------------------------------------------------------|
| `PHP_VERSION`             | Mã phiên bản PHP đầy đủ (x.y.z).                             |
| `PHPIZE_DEPS`             | Danh sách các gói phụ thuộc cần thiết để chạy `phpize`.      |
| `PHP_INI_DIR`             | Đường dẫn thư mục cấu hình cho PHP (`/usr/local/etc/php`).   |
| `FPM_CONF_DIR`            | Đường dẫn thư mục cấu hình cho PHP-FPM (`/usr/local/etc`).   |
| `DEBIAN_FRONTEND`         | `noninteractive` - Chế độ không cần tương tác trong Console. |
| `PHP_MAJOR_MINOR_VERSION` | Mã phiên bản PHP MAJOR.MINOR (x.y).                          |

## #Các gói đã cài đặt (Linux packages)

### #ĐƯỢC BAO GỒM trong hình ảnh docker `php:{x.y}-fpm`

| Gói             | Ghi chú                                                                                                                                                                |
|:----------------|:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| bash            | Bash (Bourne Again Shell) là phiên bản miễn phí và nâng cao của Bourne shell được phân phối cùng với hệ điều hành Linux và GNU.                                        |
| ca-certificates | Chứng chỉ CA là chứng chỉ kỹ thuật số do cơ quan cấp chứng chỉ (CA) cấp, do đó, ứng dụng khách SSL có thể sử dụng chứng chỉ đó để xác minh chứng chỉ SSL do CA này ký. |
| curl            | cURL là một công cụ CLI cho phép bạn yêu cầu và truyền dữ liệu qua một URL theo các giao thức khác nhau.                                                               |
| openssl         | OpenSSL là một công cụ dòng lệnh nguồn mở thường được sử dụng để tạo khóa riêng, tạo CSR, cài đặt chứng chỉ SSL/TLS của bạn và xác định thông tin chứng chỉ.           |
| tzdata          | Gói tzdata chứa các tệp dữ liệu ghi lại cả quá trình chuyển đổi hiện tại và lịch sử cho các múi giờ khác nhau trên thế giới.                                           |

### #Đã cài đặt thêm

| Gói                 | Ghi chú                                                                                                                                         |
|:--------------------|:------------------------------------------------------------------------------------------------------------------------------------------------|
| apt-utils           | Gói apt-utils là tập hợp các tiện ích được sử dụng để quản lý hệ thống Công cụ đóng gói nâng cao (APT) trong Linux.                             |
| apt-transport-https | APT transport để tải xuống qua giao thức HTTP Secure (HTTPS).                                                                                   |
| lsb-release         | Lệnh lsb-release là một công cụ đơn giản giúp xác định Linux. bản phân phối đang được sử dụng và sự tuân thủ của nó với Cơ sở tiêu chuẩn Linux. |
| wget                | GNU Wget là một tiện ích dòng lệnh để tải xuống các tệp từ web.                                                                                 |
| gnupg               | GnuPG 1.4 là công cụ của GNU để lưu trữ dữ liệu và liên lạc an toàn. Nó có thể được sử dụng để mã hóa dữ liệu và tạo chữ ký số.                 |
| gnupg2              | GnuPG 2.0 là phiên bản mới hơn của GnuPG có hỗ trợ bổ sung cho S/MIME.                                                                          |
| zip                 | Lệnh zip là một công cụ dòng lệnh trong Linux cho phép chúng ta tạo một kho lưu trữ các tệp và thư mục.                                         |
| unzip               | Unzip là một tiện ích giúp bạn liệt kê, kiểm tra và trích xuất các kho lưu trữ ZIP đã nén.                                                      |
| git                 | GIT là hệ thống kiểm soát phiên bản phân tán linh hoạt nhất.                                                                                    | 

## #Các trình quản lý mã nguồn được hỗ trợ

| Tên      | Ghi chú                                                                             | Trang chủ                                  | Để cài đặt                                                                      |
|:---------|:------------------------------------------------------------------------------------|:-------------------------------------------|:--------------------------------------------------------------------------------|
| composer | Composer là một công cụ để quản lý sự phụ thuộc trong PHP.                          | [getcomposer.org](https://getcomposer.org) | `JV_INSTALL_COMPOSER=true`                                                      |
| node/npm | NPM là trình quản lý gói cho các gói hoặc mô-đun Node.js.                           | [nodejs.org](https://nodejs.org)           | `JV_INSTALL_NODEJS=true`<br/>_Yêu cầu phiên bản NodeJS:_ `JV_NODEJS_VERSION=xx` |
| yarn     | Yarn là trình quản lý gói mới dành cho JavaScript.                                  | [yarnpkg.com](https://yarnpkg.com)         | `JV_INSTALL_YARN=true`<br/>_Yêu cầu bao gồm NodeJS:_ `JV_INSTALL_NODEJS=true`   |
| bower    | Bower có thể quản lý các thành phần chứa HTML, CSS, JavaScript, Fronts hoặc Images. | [bower.io](https://bower.io)               | `JV_INSTALL_BOWER=true`<br/>_Yêu cầu bao gồm NodeJS:_ `JV_INSTALL_NODEJS=true`  |
| sass     | SASS là bộ tiền xử lý CSS, là ngôn ngữ kịch bản mở rộng CSS.                        | [sass-lang.com](https://sass-lang.com)     | `JV_INSTALL_SASS=true`<br/>_Yêu cầu bao gồm NodeJS:_ `JV_INSTALL_NODEJS=true`   |

**🔥QUAN TRỌNG: Hỗ trợ NodeJS với các phiên bản hệ điều hành của bản dựng PHP:**

> Được hỗ trợ với bản dựng PHP:
> - ✅ : Được hỗ trợ.
> - ❌ : Không hỗ trợ.

_Phiên bản NPM tại thời điểm: `latest = 10.x.y` ._

<!-- https://github.com/nodesource/distributions/blob/master/README.md -->

| Phiên bản PHP | PHP 8.4  | PHP 8.4  | PHP 8.3  | PHP 8.3  | PHP 8.2  | PHP 8.2  | PHP 8.1  | PHP 8.1  | Hỗ trợ NPM  | Để cài đặt             |
|:--------------|:--------:|:--------:|:--------:|:--------:|:--------:|:--------:|:--------:|:--------:|:-----------:|:-----------------------|
| Distribution  | Bookworm | Bullseye | Bookworm | Bullseye | Bookworm | Bullseye | Bookworm | Bullseye | ----------- | ---------------------- |
| Debian OS     |    12    |    11    |    12    |    11    |    12    |    11    |    12    |    11    | ----------- | ---------------------- |
| ------------  | -------- | -------- | -------- | -------- | -------- | -------- | -------- | -------- | ----------- | ---------------------- |
| NodeJS 18     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=18` |
| NodeJS 20     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=20` |
| NodeJS 21     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=21` |
| NodeJS 22     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=22` |
| NodeJS 23     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=23` |

## #PHPUnit được hỗ trợ

<!-- https://phpunit.de/supported-versions.html -->

| Phiên bản PHP     | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Để cài đặt                |
|:------------------|:-------:|:-------:|:-------:|:-------:|:--------------------------|
| Phiên bản PHPUnit |   11    |   11    |   11    |   10    | `JV_INSTALL_PHPUNIT=true` |

## #Cài đặt PHP-Extensions

> Được hỗ trợ với phiên bản PHP:
> - ✅ : Được hỗ trợ.
> - ❌ : Không hỗ trợ.

### #ĐƯỢC BAO GỒM trong hình ảnh docker `php:{x.y}-fpm`

<!-- Xem chi tiết: https://github.com/mlocati/docker-php-extension-installer/blob/master/README.md#supported-php-extensions -->
<!-- Link icon: https://emojipedia.org/unicode-6.0 -->

> ➕ : Được hỗ trợ (Không có sẵn trong `php:{x.y}-fpm` - Nhưng đã được cài đặt mặc định).

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Tên                                                                             |
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

### #Các Extension khác được hỗ trợ

- Các Extension về Database:

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Tên                                                                                        | Để cài đặt                |
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

- Các Extension về xử lý hình ảnh:

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Tên                                                                           | Để cài đặt                |
|:-----------|:-------:|:-------:|:-------:|:-------:|:------------------------------------------------------------------------------|:--------------------------|
| exif       |    ✅    |    ✅    |    ✅    |    ✅    | [Exchangeable image information](https://www.php.net/manual/en/book.exif.php) | `JV_INSTALL_EXIF=true`    |
| gd         |    ✅    |    ✅    |    ✅    |    ✅    | [Image Processing and GD](https://www.php.net/manual/en/book.image.php)       | `JV_INSTALL_GD=true`      |
| imagick    |    ✅    |    ✅    |    ✅    |    ✅    | [Image Processing](https://www.php.net/manual/en/book.imagick.php)            | `JV_INSTALL_IMAGICK=true` |

- Các Extension về Mật mã bảo mật(Cryptography):

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Tên                                                               | Để cài đặt                 |
|:-----------|:-------:|:-------:|:-------:|:-------:|:------------------------------------------------------------------|:---------------------------|
| gnupg      |    ✅    |    ✅    |    ✅    |    ✅    | [GNU Privacy Guard](https://www.php.net/manual/en/book.gnupg.php) | `JV_INSTALL_GNUPG=true`    |
| igbinary   |    ✅    |    ✅    |    ✅    |    ✅    | [Igbinary](https://www.php.net/manual/en/book.igbinary.php)       | `JV_INSTALL_IGBINARY=true` |
| mcrypt     |    ❌    |    ✅    |    ✅    |    ✅    | [Mcrypt](https://www.php.net/manual/en/book.mcrypt.php)           | `JV_INSTALL_MCRYPT=true`   |
| msgpack    |    ✅    |    ✅    |    ✅    |    ✅    | [MsgPack](https://pecl.php.net/package/msgpack)                   | `JV_INSTALL_MSGPACK=true`  |

- Các Extension về các giao thức(Protocol):

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Tên                                                                                  | Để cài đặt               | Yêu cầu các Extension khác |
|:-----------|:-------:|:-------:|:-------:|:-------:|:-------------------------------------------------------------------------------------|:-------------------------|:---------------------------|
| imap       |    ✅    |    ✅    |    ✅    |    ✅    | [IMAP, POP3 and NNTP](https://www.php.net/manual/en/book.imap.php)                   | `JV_INSTALL_IMAP=true`   |                            |
| ldap       |    ✅    |    ✅    |    ✅    |    ✅    | [Lightweight Directory Access Protocol](https://www.php.net/manual/en/book.ldap.php) | `JV_INSTALL_LDAP=true`   |                            |
| soap       |    ✅    |    ✅    |    ✅    |    ✅    | [SOAP](https://www.php.net/manual/en/book.soap.php)                                  | `JV_INSTALL_SOAP=true`   | `libxml`                   |
| sockets    |    ✅    |    ✅    |    ✅    |    ✅    | [Sockets](https://www.php.net/manual/en/book.sockets.php)                            | `JV_INSTALL_SOCKET=true` |                            |
| ssh2       |    ✅    |    ✅    |    ✅    |    ✅    | [Secure Shell2](https://www.php.net/manual/en/book.ssh2.php)                         | `JV_INSTALL_SSH2=true`   |                            |

- Các Extension khác:

| Extensions | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | Tên                                                                                 | Để cài đặt                  | Yêu cầu các Extension khác |
|:-----------|:-------:|:-------:|:-------:|:-------:|:------------------------------------------------------------------------------------|:----------------------------|:---------------------------|
| bcmath     |    ✅    |    ✅    |    ✅    |    ✅    | [BCMath Arbitrary Precision Mathematics](https://www.php.net/manual/en/book.bc.php) | `JV_INSTALL_BCMATH=true`    |                            |
| bz2        |    ✅    |    ✅    |    ✅    |    ✅    | [Bzip2](https://www.php.net/manual/en/book.bzip2.php)                               | `JV_INSTALL_BZ2=true`       |                            |
| calendar   |    ✅    |    ✅    |    ✅    |    ✅    | [Calendar](https://www.php.net/manual/en/book.calendar.php)                         | `JV_INSTALL_CALENDAR=true`  |                            |
| decimal    |    ✅    |    ✅    |    ✅    |    ✅    | [Arbitrary precision floating-point decimal](https://pecl.php.net/package/decimal)  | `JV_INSTALL_DECIMAL=true`   |                            |
| event      |    ✅    |    ✅    |    ✅    |    ✅    | [Event](https://www.php.net/manual/en/book.event.php)                               | `JV_INSTALL_EVENT=true`     | `openssl sockets`          |
| intl       |    ✅    |    ✅    |    ✅    |    ✅    | [Internationalization Functions](https://www.php.net/manual/en/book.intl.php)       | `JV_INSTALL_INTL=true`      |                            |
| memcached  |    ✅    |    ✅    |    ✅    |    ✅    | [Memcached](https://www.php.net/manual/en/book.memcached.php)                       | `JV_INSTALL_MEMCACHED=true` | `json session igbinary`    |
| opcache    |    ✅    |    ✅    |    ✅    |    ✅    | [Zend OPcache](https://www.php.net/manual/en/book.opcache.php)                      | `JV_INSTALL_OPCACHE=true`   |                            |
| pcntl      |    ✅    |    ✅    |    ✅    |    ✅    | [Process Control](https://www.php.net/manual/en/book.pcntl.php)                     | `JV_INSTALL_PCNTL=true`     |                            |
| xdebug     |    ✅    |    ✅    |    ✅    |    ✅    | [Xdebug](https://pecl.php.net/package/xdebug)                                       | `JV_INSTALL_XDEBUG=true`    |                            |
| xlswriter  |    ✅    |    ✅    |    ✅    |    ✅    | [XLSWriter](https://pecl.php.net/package/xlswriter)                                 | `JV_INSTALL_XLSWRITER=true` |                            |
| xsl        |    ✅    |    ✅    |    ✅    |    ✅    | [XSL implements the XSL standard](https://www.php.net/manual/en/book.xsl.php)       | `JV_INSTALL_XSL=true`       |                            |
| yaml       |    ✅    |    ✅    |    ✅    |    ✅    | [YAML Data Serialization](https://www.php.net/manual/en/book.yaml.php)              | `JV_INSTALL_YAML=true`      |                            |
| zip        |    ✅    |    ✅    |    ✅    |    ✅    | [ZIP](https://www.php.net/manual/en/book.zip.php)                                   | `JV_INSTALL_ZIP=true`       |                            |

> **Tham khảo:**
> - Các Extension về Database: [Link](https://www.php.net/manual/en/refs.database.php)
> - Các Extension về PDO Driver: [Link](https://www.php.net/manual/en/pdo.drivers.php)
> - PHP Function tham khảo: [Link](https://www.php.net/manual/en/funcref.php)
> - Tải xuống Oracle Instant Client cho Linux: [Link](https://www.oracle.com/database/technologies/instant-client/linux-x86-64-downloads.html)
> - Các PHP Extension được hỗ trợ: [Link](https://github.com/mlocati/docker-php-extension-installer/blob/master/README.md#supported-php-extensions)

## #Đã được cấu hình

- `/usr/local/etc/php/` : Thư mục chứa tệp cấu hình cho PHP (`php.ini`).
- `/usr/local/etc/php/conf.d/` : Thư mục chứa các tệp cấu hình tùy chỉnh cho PHP.
- `/usr/local/etc/` : Thư mục chứa tệp cấu hình cho PHP-FPM (`php-fpm.conf`).
- `/usr/local/etc/php-fpm.d/` : Thư mục chứa các tệp cấu hình tùy chỉnh cho PHP-FPM.
- `/var/log/php` : Thư mục nhật ký cho PHP và PHP-FPM.
