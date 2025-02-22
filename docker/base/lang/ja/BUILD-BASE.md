# BUILD BASE-IMAGE

_(基本環境はほとんど変更/アップグレードされませんが、構築には時間がかかるため、ここまで分離してこのドキュメントに準拠して構築します。)_

**プロジェクト ディレクトリのルートから始めて、次の手順を実行します:**

## #ステップ1: 移動

- プロジェクトのルートディレクトリから、移動します:
```bash
cd ./docker/base
```

## #ステップ2: 構成

_(この手順は、プロジェクトを作成するときに初めてのみ実行されます。)_

- サンプル環境ファイルをコピーし、現在のディレクトリに保存します (必要な名前 `.env` を付けます)。
```bash
cp .env-temp.env .env
```

- 環境に合わせて構成情報を変更し、ブロックします:
  + `## PROJECT`
  + `## BASE IMAGE NAME`
  + `## PHP VERSION`
  + `## PHP EXTENSION OPTION INSTALL`

> 📝**注記:**
> - `COMPOSE_PROJECT_NAME`: プロジェクト名です。Docker-Compose によって使用されます。この値は、起動時にコンテナ名の前にサービス名が付加されます。
> - `JV_BASE_IMAGE_NAME`: ビルドする Dockerイメージ `Base-Image` の名前です (完全な `repository:tag` 名のコンポーネントを含む)。
> - `JV_PHP_VERSION`: `Base-Image` Dockerイメージでビルドする PHP バージョンです。
> - `JV_DISTRIBUTION`: `Base-Image` Dockerイメージを構築する Debian OS のカーネル バージョンです。
>                      空白のままにします -> サポートされている最新バージョン (上記で選択した PHP バージョンに対応 - `JV_PHP_VERSION`)。
> - `JV_INSTALL_...`: これらのプレフィックスの値は、インストールの Yes/No の選択肢である `true/false` (小文字) の 2 つの値を受け入れます。
>
>> - 理解を深めるために、コピーした `.env` ファイル内の注記を注意深く読んでください。
>> - プロジェクトに適切な PHP 拡張機能を必ずインストールしてください。
>> - 過剰にインストールしないでください。過剰にインストールすると、Dockerイメージの容量が増加し、リソースが浪費され、ビルド時間が長くなります。

- 設定した情報を `.env` ファイルに保存し、プロジェクト GIT にプッシュします。

> 🔥**重要:**
>> このソース コードを実際のプロジェクトにコピーする場合:
>> - それに応じて `.env` ファイル内のパラメータを設定します。
>> - `/docker/base/.gitignore` ファイルを編集し (`.env` 部分を削除)、`.env` ファイルをプロジェクトの GIT にプッシュします。
>> <br/><br/>
>> ==> `目的は、プロジェクトの Base-Image Dockerイメージの構成を保存することです。`

## #ステップ3: Dockerイメージを構築する

- パラメータを使用してイメージを構築します (_よく使われる_):
```bash
bash build.sh --no-cache --memory=512m --progress=plain
```

> 📝**注記:**
> - サポートされているパラメータのリストを表示するには、次のコマンドを実行します:
> ```bash
> bash build.sh -h
> ```

## #ステップ 4: 戻ってくる

- Dockerイメージを正常にビルドしたら、次のコマンドを実行してプロジェクトのルート ディレクトリに戻ります:
```bash
cd ../../
```

# END !!!
