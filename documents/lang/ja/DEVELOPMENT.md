# BUILD AND DEPLOY

_`Base-Image`は`ベースDockerイメージ`の略です_  
_`App-Image`は`アプリケーションDockerイメージ`の略です_  

ドキュメント: Development環境用の`App-Image`の構築とデプロイ。

**プロジェクト ディレクトリのルートから始めて、次の手順を実行します:**

## #ステップ 0: 初期化 (`Base-Image`のビルド)

2方法:

- 方法 1: `Base-Image`を手動でビルドする - 次のドキュメントに従ってください:
  [/docker/base/BUILD-BASE.md](../../../docker/base/lang/ja/BUILD-BASE.md)。

- 方法 2: `Base-Image`を自動的にビルドする - `#ステップ 3`を参照してください。

> ただし、プロジェクトを初めて開始するときは、`#方法 1`のドキュメントを参照して、`Base-Image`の環境変数 (`.env`) を構成する方法を確認してください。

## #ステップ 1: 環境変数ファイルの構成

- 環境ファイル (必須の名前 `.env`) をコピーします:
```bash
cp ./.env-local.env ./.env
```

- 環境に合わせて構成情報を変更し、ブロックします:
    + `## SAIL CONFIGURATION FOR DEVELOPMENT ##`
    + `## SUPERVISOR TURN ON/OFF SERVICE ##`
    + `## FOR APP ##`
    + ...

> 📝**注記:**
> - `## SAIL CONFIGURATION FOR DEVELOPMENT ##`:
>>  + `COMPOSE_PROJECT_NAME`: プロジェクトに名前を付けます（Docker-Compose の形式に従います）。 この値は、起動時に Container の名前の前にサービス名が付加されます。
>>  + `COMPOSE_PROJECT_NETWORK`: プロジェクトの内部ネットワークに名前を付けます（Docker-Compose に従った形式）。 この値は Docker-Compose によって作成され、プロジェクトの Network という名前が付けられます。
>>  + `SAIL_FILES`: `docker-compose.yml` 構成ファイルへの絶対パス。_(プロジェクト ルートから始まり、先頭に `/` が付かない)_。
>>  + `APP_IMAGE_NAME`: `App-Image`の名前。_(プロジェクトに適切な名前を付けます。例: `coffee/backend-app:latest`)_。
>>  + `APP_SERVICE`: Appコンテナに対応する `service` 名は `docker-compose.yml` ファイルで構成されます。
>>  + `APP_PORT`/`APP_PORT_SSL`: Appにアクセスするためのポート (それぞれ http と https)。
>>  + `SUPERVISOR_PORT`: このポートは、Appのそれぞれのサービス/プロセスを管理する`Supervisord`マネージャーにアクセスするために使用されます。
>>  + `..._TAG`: サフィックス - `docker-compose.yml` ファイル内の `services` の Docker イメージ (バージョン) タグに対応します。
>>  + `..._FORWARD`: サフィックス - 他のサービス、つまり`docker-compose.yml`ファイルの`services`で設定されたアプリケーションにアクセスするために使用されるポートに対応します。
>
> - `## SUPERVISOR TURN ON/OFF SERVICE ##`:
>>  + `SUV_WEB_SERVER`:          Supervisord の管理下にある `Web-Server(Nginx/Apache)` サービスを有効(`true`) - 無効(`false`) にします。
>>  + `SUV_SCHEDULER`:           Supervisord の管理下にある `Scheduler(Laravel)` サービスを有効(`true`) - 無効(`false`) にします。
>>  + `SUV_SCHEDULER_NUMPROCS`:  Supervisord が作成する `Scheduler(Laravel)` プロセスの数です (デフォルト: `SUV_SCHEDULER=false` の場合は 0、`SUV_SCHEDULER=true` の場合は 1、空の `SUV_SCHEDULER_NUMPROCS`)。
>>  + `SUV_WORKER`:              Supervisord の管理下にある `Worker(Laravel)` サービスを有効(`true`) - 無効(`false`) にします。
>>  + `SUV_WORKER_NUMPROCS`:     Supervisord が作成する `Worker(Laravel)` プロセスの数です (デフォルト: `SUV_WORKER=false` の場合は 0、`SUV_WORKER=true` の場合は 1、空の `SUV_WORKER_NUMPROCS`)。
>
> - `## FOR APP ##`:
>>  + このブロックの構成は、PHP アプリケーションの構成です。
>
>> - さらに、他のすべての構成は同じままにすることができます。
>> - コピーした `.env` ファイル内の注記をよく読んでください。

## #ステップ 2: `sail` の概要とインストール (コマンドラインインターフェイス)

### #`sail`のご紹介

- `sail`: Laravel のデフォルトの Docker 開発環境と対話するための軽量のコマンドライン インターフェイスです。  
  詳細情報は[こちら](https://laravel.com/docs/11.x/sail#introduction)をご覧ください。

- `sail`: macOS、Linux、Windows ([WSL2](https://learn.microsoft.com/en-us/windows/wsl/about) 経由) でサポートされています。

- `docker/sail`: プロジェクトに含まれるのは Laravel Sail のコピーであり、プロジェクトの意図された用途に合わせて調整されています。  
  例:  
    - `php-fpm`と`nginx`を組み合わせて使用する場合の権限に一致するように、デフォルトのユーザーを`sail`から`www-data`に設定します。  
      _(Laravel Sail は元々、`ubuntu`と`apache2`の間の統合として使用されました。)_
    - `Base-Image` ビルド ステップと直接対話して、開発ステップを簡素化できます。

### #`sail`をインストールする

`sail`はコマンドラインインターフェースであるため、特定の権限を付与する必要があります。

`sail` の実行可能な設定:
```bash
bash ./docker/setup_sail.sh
```

- `sail`コマンドラインリストのクイックガイド:
```bash
./docker/sail --help
```

## #ステップ 3: ビルド - アプリケーションを起動します

- パラメータを使用して`App-Image`をビルドします:
```bash
./docker/sail build --no-cache --memory=512M --progress=plain
```

> 📝**注記:**
> - `--no-cache` : ビルド時にキャッシュを使用しないでください。
> - `--memory=512M` : ビルドプロセスのMemory制限を設定します。
> - `--progress=plain` : Console画面で詳細なビルド履歴を確認します。
>> **最初のビルド時、または `build`パラメータを使用する場合、`Base-Image`のビルドが自動的に有効になります - `#ステップ 0 / 方法 2`でプロンプトが表示されます。**  
>> 次に、`App-Image`を構築する手順に進みます。

- `sail` でアプリケーションを起動します:
```bash
./docker/sail up -d
```

> 📝パラメータは拡張できます:
> - `--build` : コンテナを起動する前に、`App-Image`の再構築を強制します。
>> **最初のビルドでは、`#ステップ 0 / 方法 2`でプロンプトが表示され、`Base-Image`のビルドも自動的にトリガーされます。**  
>> 次に、`App-Image`をビルドし、コンテナを起動する手順に進みます。

> 🔥**重要:**
> - 「ERROR [internal] load metadata for `docker.io/xxxyyy:latest`」というエラーが発生した場合は、`sudo`権限を使用して再試行してください。

## #延長: 

- App bash にログインします (ユーザー: `www-data`):
```bash
./docker/sail bash
```

- App bash にログインします (ユーザー: `root`):
```bash
./docker/sail root-bash
```

- PHP の依存ライブラリをインストールする:
```bash
./docker/sail composer install --optimize-autoloader
```
