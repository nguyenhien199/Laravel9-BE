# BUILD AND DEPLOY - PRODUCTION

_`Base-Image`は`ベースDockerイメージ`の略です_  
_`App-Image`は`アプリケーションDockerイメージ`の略です_  

ドキュメント: Production環境用の`App-Image`の構築とデプロイ。

> 前提条件: 運用サーバーに Unix Shell(`bash`)、Docker エンジン、および Docker-Compose (Docker Compose プラグインを含む) がインストールされていることを確認してください。

## #`App-Image` をビルドする - 手動で

**プロジェクト ディレクトリのルートから始めて、次の手順を実行します:**

### #ステップ 0: 初期化（`Base-Image` のビルド）

2方法:

- 方法 1: `Base-Image`を手動でビルドする - 次のドキュメントに従ってください:
  [/docker/base/BUILD-BASE.md](../../../docker/base/lang/ja/BUILD-BASE.md)。

- 方法 2: `Base-Image`を自動的にビルドする - `#ステップ 1`を参照してください。

> ただし、プロジェクトを初めて開始するときは、`#方法 1`のドキュメントを参照して、`Base-Image`の環境変数 (`.env`) を構成する方法を確認してください。

### #ステップ 1: `App-Image` をビルドする

- パラメータを使用して `App-Image` をビルドします:
```bash
bash ./docker/production/build.sh --no-cache --memory=512m --progress=plain
```

> 📝パラメータは拡張できます:
> - `--no-cache`: ビルド時に Docker キャッシュを使用しないでください。
> - `--memory=512M` : ビルド時にMemory容量制限を設定します。
> - `--progress=plain` : Console画面で詳細なビルド履歴を表示します。
> - `--build-base`: Docker Base-Image の再構築を強制します。
> - `--name=NAME`: パラメータは、構築するイメージの名前を指定します。  
>    _(初めてプロジェクトをビルドするときは、スクリプト `/docker/production/build.sh` 内の変数 `PROD_IMAGE_REPO` を編集してイメージのデフォルト名を設定し、このパラメーターを頻繁に渡す必要を避ける必要があります。)_
> - `--tag=TAG`: 画像用のTagが構築されます。
>> **最初のビルド時、または `--build-base` パラメーターを使用する場合、Docker Base-Image ビルドが自動的に有効になります - `#ステップ 0` でプロンプトが表示されます。**  
>> 次に、`App-Image` ビルド ステップが続きます。

- サポートされているすべてのパラメータを表示するには、次のコマンドを実行します:
```bash
bash ./docker/production/build.sh -h
```

> 上記の手順で `App-Image` が完全に構築されました。  
> 
> 通常の方法で Docker Engine がインストールされた Linux カーネル ホストに Docker イメージをデプロイするには、
> [docker run](https://docs.docker.com/reference/cli/docker/container/run) コマンドを学習してください。

## #`App-Image` を構築して運用環境にデプロイする - Bash スクリプトを使用します

ソース コードには、テンプレート ファイル `/docker/common/templates/bash_deploy_script.sh` があります。  
主な処理内容は以下のとおりです:

- GIT と対話して _(分岐をフォーク/最新のコードを取得/指定されたコミット ID にジャンプ)_して、ソース コードを `App-Image` にパッケージ化します。
- コマンドを `/docker/production/build.sh` に転送して、`App-Image` ビルド コマンドを実行します。 _(上記の`App-Image をビルドする - 手動で`セクションで説明されています)_。
- 古い Container を Docker システムから削除します。
- 新しく構築された `App-Image` に基づいて、新しい Container を初期化します _(選択用のパラメーターがあります)_。
- 古い Docker イメージ (名前のないイメージ) を削除し、キャッシュをクリアします _(選択用のパラメーターがあります)_。

### #運用サーバーの構成

> 次の手順は、最初の展開時に 1 回だけ実行されます。

1. サーバー上にプロジェクトフォルダーを作成します。 (例: ディレクトリ パス `~/project`)。  
   + `mkdir ~/project` -> プロジェクトフォルダー。
   + `mkdir ~/project/source` -> ソースコードのディレクトリ。
   + `mkdir ~/project/warehouses` -> リポジトリフォルダー。
   + `mkdir ~/project/configs` -> 設定ファイルのディレクトリ。

2. サンプル ファイル `bash_deploy_script.sh` を新しく作成したディレクトリ `~/project/bash_deploy_script.sh` にアップロードします。

3. 環境変数構成ファイル (`~/project/configs/production.env`) を作成 (またはアップロード) し、プロジェクトに適切な環境変数を構成します。

4. Git サーバーで SSH キーを構成します (Git Web サイト) - スクリプトは SSH キーによる認証を通じて GIT と対話するためです。  
   _Gitlab の手順を参照してください [こちら](https://docs.gitlab.com/ee/user/ssh.html)._  
   📝 _(デプロイするたびにユーザー名/パスワードを使用して GIT 認証を使用する場合は、この手順をスキップしてください。)_

5. 新しく作成した SSH 秘密キー ファイルをサーバーにアップロードします。このファイルは、ssh に接続しているユーザーに対応する `~/.ssh` ディレクトリに保存される必要があります。  
   📝 _(デプロイするたびにユーザー名/パスワードを使用して GIT 認証を使用する場合は、この手順をスキップしてください。)_

6. ソース コードを初期化し、サーバーに初めてプルします (「git clone」を使用する) - 新しく作成されたディレクトリ `~/project/source` に移動します。

7. スクリプト `~/project/bash_deploy_script.sh` でパラメータを設定します。

   - `SOURCE_TO_BUILD`: `App-Image` ビルドを実行するための Bash スクリプト `build.sh` を含む、Docker ディレクトリ内のサブディレクトリ名。
   - `PWD_WORKDIR`: 作成したばかりのソース コード (`~/project/source`) を含むディレクトリ パス。
   - `PWD_WAREHOUSE`: 作成したばかりのリポジトリ ディレクトリ パス (`~/project/warehouses`)。
   - `ENV_FILE`: 作成したばかりの環境変数設定ファイル (`~/project/configs/production.env`) のパス。
   - 
   - `GIT_REMOTE_URL`: ソース コードをプルするために使用する Git リポジトリの URL。
   - `GIT_REMOTE_NAME`: Git Remote がソース コードをプルするために使用する名前 (デフォルトは「origin」)。
   - `GIT_BRANCH_NAME`: `App-Image` をビルドするデフォルトのブランチ名 (デフォルトは `master`)。
   - `GIT_SSH_KEY`: SSH 秘密鍵ファイル パス (`~/.ssh/...`) がアップロードされました _(認証にユーザー名/パスワードを使用する場合 -> 空白のままにします)_。
   - 
   - `PROJECT_NETWORK`: `App-Image`のコンテナがバインドされるDocker上のネットワーク名 _(バインドしたくない場合 -> 空白のまま)_。
   - `APP_IMAGE_REPO`: ビルドする `App-Image` のデフォルトの名前を設定します (プロジェクトに応じて設定します。例: `coffee/backend-app`) **🔥注: イメージの TAG 部分を含めないでください**。
   - `APP_IMAGE_TAG`: `App-Image` のデフォルトのタグを設定します - ビルドされたバージョンをマークするために使用されます (例: `latest`)。
   - `APP_CONTAINER_NAME`: `App-Image` をデプロイするときに Container という名前を付ける。
   - 
   - `APP_PORT_HTTP`/`APP_PORT_HTTPS`: アプリコンテナのそれぞれのアプリケーションにアクセスするために使用される 2 つのポート (http および https) に対応します _(ポート転送を希望しない場合 -> 空白のままにしてください)_。
   - `SUPERVISOR_PORT`: このポートは、アプリ コンテナのそれぞれのサービス/プロセスを管理する`Supervisord`マネージャーにアクセスするために使用されます _(ポート転送を希望しない場合 -> 空白のままにしてください)_。
   - 
   - `PWD_WAREHOUSE_...`: ディレクトリ パスは、`App-Image` コンテナー内の対応するディレクトリにマウントされます (リンクしない場合は空白のままにします)。
   - `PWD_CONTAINER_...`: マウントされる `App-Image` のコンテナ内のディレクトリ パス _(正確なパスを指定してください)_。   
   > - 🔥このステップのすべてのフォルダー/ファイル パス -> 絶対パスを使用する必要があります。
   > - 🔥それ以外の場合、記載されていない他のすべての構成は同じままです。

### #Bash スクリプトの実行 - 継続的展開

- ビルド - パラメーターを使用してデプロイする:
```bash
# 例:
bash ~/project/bash_deploy_script.sh --no-cache --memory=512m --progress=plain --rmi
```

- サポートされているすべてのパラメータを確認するには、次のコマンドを実行します:
```bash
bash ~/project/bash_deploy_script.sh -h
```
