# BUILD AND DEPLOY - TESTING

ドキュメント: Testing境用に構築してデプロイします。

**📝ドキュメントの指示に従ってください: [Production境用に構築してデプロイします](./PRODUCTION.md).**

次の違いに注目してください:

- セクション `#ステップ 1: App-Image をビルドする`, 
  新しいテスト環境では、`docker/production` ディレクトリの Bash スクリプトを使用する代わりに、`docker/testing` ディレクトリの Bash スクリプトを使用します。
  _(スクリプト内のパラメーターは同じままです)_。
   ```bash
   'bash ./docker/production/build.sh ...'
   ->
   'bash ./docker/testing/build.sh ...'
   ```

- セクション `#を構築して境にデプ ... - Bash スクリプトを使用します` -> `#サーバーの構成` -> `3. 環境変数設定ファイルを作成（またはアップロード）する...`: 
  混乱を避けるために、ファイルに `production.env` という名前を付ける代わりに、環境名に対応する `testing.env` という名前を付けます。


- セクション `#を構築して境にデプ ... - Bash スクリプトを使用します` -> `#サーバーの構成` -> `7. スクリプト ~/project/bash_deploy_script.sh でパラメータを設定します`, 
  `SOURCE_TO_BUILD="testing"` パラメータは必須です。
  さらに、残りのパラメータは Testing 環境に合わせて適切に設定する必要があります。
