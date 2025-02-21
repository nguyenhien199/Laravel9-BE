# DOCKER BASE IMAGE

`php:{x.y}-fpm` Docker イメージからビルドします。

## #宣言された ENV のリスト

| ENVs                      |                                          |
|:--------------------------|:-----------------------------------------|
| `PHP_VERSION`             | PHP の完全バージョン (x.y.z)。                    |
| `PHPIZE_DEPS`             | `phpize` を実行するために必要な依存パッケージのリスト。         |
| `PHP_INI_DIR`             | PHP の設定ディレクトリ パス (`/usr/local/etc/php`)。 |
| `FPM_CONF_DIR`            | PHP-FPM の設定ディレクトリ パス (`/usr/local/etc`)。 |
| `DEBIAN_FRONTEND`         | `noninteractive`- コンソールの非対話型モード。         |
| `PHP_MAJOR_MINOR_VERSION` | PHP バージョン MAJOR.MINOR (x.y)。             |

## #インストール済みパッケージ (Linuxパッケージ)

### #Dockerイメージ `php:{x.y}-fpm` に含まれています

| パッケージ           | ノート                                                                                                   |
|:----------------|:------------------------------------------------------------------------------------------------------|
| bash            | Bash (Bourne Again Shell) は、Linux および GNU オペレーティング システムで配布される Bourne シェルの無料の拡張バージョンです。                |
| ca-certificates | CA 証明書は認証局 (CA) によって発行されたデジタル証明書であるため、SSL クライアントはそれを使用して、この CA によって署名された SSL 証明書を検証できます。              |
| curl            | cURL は、さまざまなプロトコルで URL を介してデータを要求および転送できる CLI ツールです。                                                  |
| openssl         | OpenSSL は、秘密キーの生成、CSR の作成、SSL/TLS 証明書のインストール、および証明書情報の識別に一般的に使用されるオープンソースのコマンド ライン ツールです。             |
| tzdata          | tzdata パッケージには、世界中のさまざまなタイム ゾーンの現在および過去の移行を文書化したデータ ファイルが含まれています。                                     |

### #さらにインストール済み

| パッケージ               | ノート                                                                                       |
|:--------------------|:------------------------------------------------------------------------------------------|
| apt-utils           | apt-utils パッケージは、Linux で Advanced Packaging Tool (APT) システムを管理するために使用されるユーティリティのコレクションです。 |
| apt-transport-https | HTTP セキュア プロトコル (HTTPS) 経由でダウンロードするための APT トランスポート。                                       |
| lsb-release         | lsb-release コマンドは、Linux を識別するのに役立つ簡単なツールです。 使用されているディストリビューションとその Linux 標準ベースへの準拠。        |
| wget                | GNU Wget は、Web からファイルをダウンロードするためのコマンドライン ユーティリティです。                                       |
| gnupg               | GnuPG 1.4 は、安全な通信とデータ ストレージのための GNU のツールです。 データの暗号化とデジタル署名の作成に使用できます。                     |
| gnupg2              | GnuPG 2.0 は、S/MIME のサポートが追加された GnuPG の新しいバージョンです。                                         |
| zip                 | zip コマンドは、ファイルとディレクトリのアーカイブを作成できる Linux のコマンドライン ツールです。                                   |
| unzip               | Unzip は、圧縮された ZIP アーカイブを一覧表示、テスト、抽出するのに役立つユーティリティです。                                      |
| git                 | GIT は、最も汎用性の高い分散バージョン管理システムです。                                                            | 

## #ソースコードマネージャーがサポートされています

| 名前       | ノート                                                      | ホームページ                                     | インストールするには                                                                 |
|:---------|:---------------------------------------------------------|:-------------------------------------------|:---------------------------------------------------------------------------|
| composer | Composer は、PHP の依存関係を管理するためのツールです。                       | [getcomposer.org](https://getcomposer.org) | `JV_INSTALL_COMPOSER=true`                                                 |
| node/npm | NPM は、Node.js パッケージ、または必要に応じてモジュールのパッケージ マネージャーです。       | [nodejs.org](https://nodejs.org)           | `JV_INSTALL_NODEJS=true`<br/>_NodeJS バージョンが必要です:_ `JV_NODEJS_VERSION=xx`   |
| yarn     | Yarn は JavaScript の新しいパッケージ マネージャーです。                    | [yarnpkg.com](https://yarnpkg.com)         | `JV_INSTALL_YARN=true`<br/>_NodeJS を含める必要があります:_ `JV_INSTALL_NODEJS=true`  |
| bower    | Bower は、HTML、CSS、JavaScript、フォント、または画像を含むコンポーネントを管理できます。 | [bower.io](https://bower.io)               | `JV_INSTALL_BOWER=true`<br/>_NodeJS を含める必要があります:_ `JV_INSTALL_NODEJS=true` |
| sass     | SASS は CSS プリプロセッサであり、CSS を拡張するスクリプト言語です。                | [sass-lang.com](https://sass-lang.com)     | `JV_INSTALL_SASS=true`<br/>_NodeJS を含める必要があります:_ `JV_INSTALL_NODEJS=true`  |

**🔥重要: OSバージョンのPHPビルドでのNodeJSのサポート:**

> PHPビルドでサポート:
> - ✅ : サポート済み。
> - ❌ : 未サポート。

_当時のNPMバージョン: `latest = 10.x.y` 。_

<!-- https://github.com/nodesource/distributions/blob/master/README.md -->

| PHPのバージョン    | PHP 8.4  | PHP 8.4  | PHP 8.3  | PHP 8.3  | PHP 8.2  | PHP 8.2  | PHP 8.1  | PHP 8.1  |   NPMサポート   | インストールするには             |
|:-------------|:--------:|:--------:|:--------:|:--------:|:--------:|:--------:|:--------:|:--------:|:-----------:|:-----------------------|
| Distribution | Bookworm | Bullseye | Bookworm | Bullseye | Bookworm | Bullseye | Bookworm | Bullseye | ----------- | ---------------------- |
| Debian OS    |    12    |    11    |    12    |    11    |    12    |    11    |    12    |    11    | ----------- | ---------------------- |
| ------------ | -------- | -------- | -------- | -------- | -------- | -------- | -------- | -------- | ----------- | ---------------------- |
| NodeJS 18    |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=18` |
| NodeJS 20    |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=20` |
| NodeJS 21    |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=21` |
| NodeJS 22    |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=22` |
| NodeJS 23    |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |    ✅     |  `latest`   | `JV_NODEJS_VERSION=23` |

## #PHPUnit がサポートされています

<!-- https://phpunit.de/supported-versions.html -->

| PHPのバージョン     | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | インストールするには                |
|:--------------|:-------:|:-------:|:-------:|:-------:|:--------------------------|
| PHPUnitのバージョン |   11    |   11    |   11    |   10    | `JV_INSTALL_PHPUNIT=true` |

## #PHP 拡張機能をインストールする

> PHPバージョンでサポートされています:
> - ✅ : サポート済み。
> - ❌ : 未サポート。

### #Dockerイメージ `php:{x.y}-fpm` に含まれています

<!-- 詳細を表示: https://github.com/mlocati/docker-php-extension-installer/blob/master/README.md#supported-php-extensions -->
<!-- リンクアイコン: https://emojipedia.org/unicode-6.0 -->

> ➕ : サポート済み (`php:{x.y}-fpm` では利用できません - ただしデフォルトでインストールされます)。

| 拡張機能       | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | 名前                                                                              |
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

### #その他の拡張機能もサポートされています

- データベース(Database) 拡張機能:

| 拡張機能       | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | 名前                                                                                         | インストールするには                |
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

- 画像(Image) 拡張機能:

| 拡張機能    | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | 名前                                                                            | インストールするには                |
|:--------|:-------:|:-------:|:-------:|:-------:|:------------------------------------------------------------------------------|:--------------------------|
| exif    |    ✅    |    ✅    |    ✅    |    ✅    | [Exchangeable image information](https://www.php.net/manual/en/book.exif.php) | `JV_INSTALL_EXIF=true`    |
| gd      |    ✅    |    ✅    |    ✅    |    ✅    | [Image Processing and GD](https://www.php.net/manual/en/book.image.php)       | `JV_INSTALL_GD=true`      |
| imagick |    ✅    |    ✅    |    ✅    |    ✅    | [Image Processing](https://www.php.net/manual/en/book.imagick.php)            | `JV_INSTALL_IMAGICK=true` |

- 暗号化(Cryptography) 拡張機能:

| 拡張機能     | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | 名前                                                                | インストールするには                 |
|:---------|:-------:|:-------:|:-------:|:-------:|:------------------------------------------------------------------|:---------------------------|
| gnupg    |    ✅    |    ✅    |    ✅    |    ✅    | [GNU Privacy Guard](https://www.php.net/manual/en/book.gnupg.php) | `JV_INSTALL_GNUPG=true`    |
| igbinary |    ✅    |    ✅    |    ✅    |    ✅    | [Igbinary](https://www.php.net/manual/en/book.igbinary.php)       | `JV_INSTALL_IGBINARY=true` |
| mcrypt   |    ❌    |    ✅    |    ✅    |    ✅    | [Mcrypt](https://www.php.net/manual/en/book.mcrypt.php)           | `JV_INSTALL_MCRYPT=true`   |
| msgpack  |    ✅    |    ✅    |    ✅    |    ✅    | [MsgPack](https://pecl.php.net/package/msgpack)                   | `JV_INSTALL_MSGPACK=true`  |

- プロトコル(Protocol) 拡張機能:

| 拡張機能    | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | 名前                                                                                   | インストールするには               | 他の拡張機能が必要です |
|:--------|:-------:|:-------:|:-------:|:-------:|:-------------------------------------------------------------------------------------|:-------------------------|:------------|
| imap    |    ✅    |    ✅    |    ✅    |    ✅    | [IMAP, POP3 and NNTP](https://www.php.net/manual/en/book.imap.php)                   | `JV_INSTALL_IMAP=true`   |             |
| ldap    |    ✅    |    ✅    |    ✅    |    ✅    | [Lightweight Directory Access Protocol](https://www.php.net/manual/en/book.ldap.php) | `JV_INSTALL_LDAP=true`   |             |
| soap    |    ✅    |    ✅    |    ✅    |    ✅    | [SOAP](https://www.php.net/manual/en/book.soap.php)                                  | `JV_INSTALL_SOAP=true`   | `libxml`    |
| sockets |    ✅    |    ✅    |    ✅    |    ✅    | [Sockets](https://www.php.net/manual/en/book.sockets.php)                            | `JV_INSTALL_SOCKET=true` |             |
| ssh2    |    ✅    |    ✅    |    ✅    |    ✅    | [Secure Shell2](https://www.php.net/manual/en/book.ssh2.php)                         | `JV_INSTALL_SSH2=true`   |             |

- その他の 拡張機能:

| 拡張機能      | PHP 8.4 | PHP 8.3 | PHP 8.2 | PHP 8.1 | 名前                                                                                  | To インストールするには               | 他の拡張機能が必要です             |
|:----------|:-------:|:-------:|:-------:|:-------:|:------------------------------------------------------------------------------------|:----------------------------|:------------------------|
| bcmath    |    ✅    |    ✅    |    ✅    |    ✅    | [BCMath Arbitrary Precision Mathematics](https://www.php.net/manual/en/book.bc.php) | `JV_INSTALL_BCMATH=true`    |                         |
| bz2       |    ✅    |    ✅    |    ✅    |    ✅    | [Bzip2](https://www.php.net/manual/en/book.bzip2.php)                               | `JV_INSTALL_BZ2=true`       |                         |
| calendar  |    ✅    |    ✅    |    ✅    |    ✅    | [Calendar](https://www.php.net/manual/en/book.calendar.php)                         | `JV_INSTALL_CALENDAR=true`  |                         |
| decimal   |    ✅    |    ✅    |    ✅    |    ✅    | [Arbitrary precision floating-point decimal](https://pecl.php.net/package/decimal)  | `JV_INSTALL_DECIMAL=true`   |                         |
| event     |    ✅    |    ✅    |    ✅    |    ✅    | [Event](https://www.php.net/manual/en/book.event.php)                               | `JV_INSTALL_EVENT=true`     | `openssl sockets`       |
| intl      |    ✅    |    ✅    |    ✅    |    ✅    | [Internationalization Functions](https://www.php.net/manual/en/book.intl.php)       | `JV_INSTALL_INTL=true`      |                         |
| memcached |    ✅    |    ✅    |    ✅    |    ✅    | [Memcached](https://www.php.net/manual/en/book.memcached.php)                       | `JV_INSTALL_MEMCACHED=true` | `json session igbinary` |
| opcache   |    ✅    |    ✅    |    ✅    |    ✅    | [Zend OPcache](https://www.php.net/manual/en/book.opcache.php)                      | `JV_INSTALL_OPCACHE=true`   |                         |
| pcntl     |    ✅    |    ✅    |    ✅    |    ✅    | [Process Control](https://www.php.net/manual/en/book.pcntl.php)                     | `JV_INSTALL_PCNTL=true`     |                         |
| xdebug    |    ✅    |    ✅    |    ✅    |    ✅    | [Xdebug](https://pecl.php.net/package/xdebug)                                       | `JV_INSTALL_XDEBUG=true`    |                         |
| xlswriter |    ✅    |    ✅    |    ✅    |    ✅    | [XLSWriter](https://pecl.php.net/package/xlswriter)                                 | `JV_INSTALL_XLSWRITER=true` |                         |
| xsl       |    ✅    |    ✅    |    ✅    |    ✅    | [XSL implements the XSL standard](https://www.php.net/manual/en/book.xsl.php)       | `JV_INSTALL_XSL=true`       |                         |
| yaml      |    ✅    |    ✅    |    ✅    |    ✅    | [YAML Data Serialization](https://www.php.net/manual/en/book.yaml.php)              | `JV_INSTALL_YAML=true`      |                         |
| zip       |    ✅    |    ✅    |    ✅    |    ✅    | [ZIP](https://www.php.net/manual/en/book.zip.php)                                   | `JV_INSTALL_ZIP=true`       |                         |

> **リファレンス:**
> - Database拡張子: [Link](https://www.php.net/manual/en/refs.database.php)
> - PDO Driver拡張子: [Link](https://www.php.net/manual/en/pdo.drivers.php)
> - PHP関数リファレンス: [Link](https://www.php.net/manual/en/funcref.php)
> - Linux 用の Oracle Instant Client のダウンロード: [Link](https://www.oracle.com/database/technologies/instant-client/linux-x86-64-downloads.html)
> - サポートされている PHP 拡張機能: [Link](https://github.com/mlocati/docker-php-extension-installer/blob/master/README.md#supported-php-extensions)

## #設定済み

- `/usr/local/etc/php/` : PHP設定フォルダー (`php.ini`)。
- `/usr/local/etc/php/conf.d/` : PHPカスタム設定フォルダー。
- `/usr/local/etc/` : PHP-FPM 設定フォルダー (`php-fpm.conf`)。
- `/usr/local/etc/php-fpm.d/` : PHP-FPM カスタム設定フォルダー。
- `/var/log/php` : PHP/PHP-FPM ログ フォルダー。
