# ソースコードの構造

_ソース コードに対する構造上の変更はすべて、このドキュメントで更新されます。_

> プロジェクトのソース コード ディレクトリ構造は 2 つのコンポーネントに分かれています:
> - #基本ディレクトリ構造。
> - #Frameworkに準拠したソースコード構造。

## #基本ディレクトリ構造:

```text
boilerplate/
├── docker/    -> すべてのインストール構成、開発環境、Docker ベースのプロジェクトの運用環境のビルド スクリプトが含まれています。
└── documents/ -> プロジェクトのすべての定義/説明ドキュメントが含まれます。
```

## #Frameworkに準拠したソースコード構造:
**(Laravel フレームワークはこちらです)**

- Laravel Frameworkのルートディレクトリ構造はホームページに記載されています: https://laravel.com/docs/10.x/structure
- 
- 以下は、Laravel Framework に基づいて更新された構造を説明するツリーです:

```text
laravel/
├── app/
│   ├── Console/                                        -> すべてのカスタム Artisan コマンドが含まれています。
│   ├── Constants/                                      -> 自己定義の定数が含まれます。
│   ├── Enums/                                          -> Enumクラスが含まれています。
│   ├── Events/                                         -> イベントクラスが含まれます。
│   │   ├── Core/BaseEvent.php
│   │   └── ...Event extends Core\BaseEvent
│   ├── Exceptions/...Exception.php                     -> アプリケーションの例外ハンドラーと、アプリケーションによってスローされた例外が含まれます。
│   ├── Helpers/                                        -> カスタム ヘルパーが含まれています:
│   │   ├── Global/...Helper.php  (autoload)                - このディレクトリ内の、名前の最後に `xxxHelper.php` という単語が含まれるファイルは、`HelperServiceProvider` によって自動的にロードされます (したがって、グローバル関数として利用できます)。
│   │   └── ...Helper.php         (not autoload)            - 特定のヘルパー ファイルをグローバルにロードしたくない場合は、ヘルパー ファイルを`Helpers/Global`ディレクトリの外に配置します。
│   ├── Http/                                           -> コントローラー、ミドルウェア、フォームリクエストが含まれます。
│   │   ├── Controllers/                                    - すべてのコントローラー。
│   │   │   ├── Core/BaseController                             + システム全体のベースコントローラー。
│   │   │   ├── Admin/
│   │   │   │   ├── Core/BaseAdminController                    + Admin (Admin-CMS) ドメインのベース コントローラー。
│   │   │   │   └── ...Controller
│   │   │   │          extends Core\BaseAdminController
│   │   │   ├── Api/
│   │   │   │   ├── Admin/
│   │   │   │   │   ├── Core/BaseApiAdminController             + Admin (CMS-App) CMS API ドメインのベース コントローラー。
│   │   │   │   │   └── ...Controller
│   │   │   │   │          extends Core\BaseApiAdminController
│   │   │   │   └── Front/
│   │   │   │       ├── Core/BaseApiFrontController             + Front (Client-App) Web API ドメインのベース コントローラー。
│   │   │   │       └── ...Controller
│   │   │   │              extends Core\BaseApiFrontController
│   │   │   └── Front/
│   │   │       ├── Core/BaseFrontController                    + Front (Front-Web) Web ドメインのベース コントローラー。
│   │   │       └── ...Controller
│   │   │              extends Core\BaseFrontController
│   │   ├── Middleware/                                     - ミドルウェア。
│   │   ├── Parameters/                                     - Swagger パラメトリック スキーマ。
│   │   ├── Requests/                                       - フォームリクエスト - Swagger フォームリクエストスキーマ。
│   │   │   ├── Core                                            + 2 つの Web/API ドメインに対応する Base-FormRequest を定義します。
│   │   │   │   ├── BaseApiFormRequest
│   │   │   │   │       extends FormRequest
│   │   │   │   └── BaseFormRequest
│   │   │   │           extends FormRequest
│   │   │   ├── Admin/...FormRequest
│   │   │   │           extend Core\BaseWebFormRequest
│   │   │   ├── Api/...FormRequest
│   │   │   │           extend Core\BaseApiFormRequest
│   │   │   └── Front/...FormRequest
│   │   │               extend Core\BaseWebFormRequest
│   │   ├── Resources/                                      - オブジェクト定義 (DTO) を返します - Swagger クライアントが返すデータ オブジェクト スキーマ。
│   │   └── Responses/                                      - フォーム定義を返します - 構造スキーマが Swagger のクライアントに戻りました。
│   │       └── Traits/                                         + 特性は、クライアントへのリクエストに対して返される構造を記述します。
│   │           ├── Core/BaseResult
│   │           └── Api|WebResult use Core\BaseResult
│   ├── Jobs/                                           -> アプリケーションのキュー可能なジョブが含まれます。
│   ├── Listeners/                                      -> イベントを処理するクラスが含まれます。
│   ├── Mail/                                           -> アプリケーションによって送信される電子メールを表すすべてのクラスが含まれます。
│   ├── Models/                                         -> すべての Eloquent Model クラスが含まれます。
│   │   ├── Core                                            - BaseAuthModel|BaseModel|BasePivot は基本モデルです (モデルの共通構造を定義します)。
│   │   │   ├── BaseAuthModel|BaseModel|BasePivot
│   │   │   └── Traits/...
│   │   ├── Traits/                                         - 特性は、モデルの拡張子を定義します (目的を分離し、モデル ファイルを短縮するため)。
│   │   │   ├── Attributes/
│   │   │   ├── Methods/
│   │   │   ├── Relationships/
│   │   │   └── Scopes/
│   │   └── Something
│   │           extend BaseModel
│   │           use Traits
│   │               ...Attribute,
│   │               ...Method,
│   │               ...Relationship,
│   │               ...Scope
│   ├── Notifications/                                  -> アプリケーションによって送信されるすべての「トランザクション」通知が含まれます。
│   ├── Observers/                                      -> アプリケーションのすべてのオブザーバーが含まれます。
│   ├── Policies/                                       -> アプリケーションの認可ポリシークラスが含まれます。
│   ├── Providers/                                      -> アプリケーションのすべてのサービス プロバイダーが含まれます。
│   ├── Repositories/                                   -> アプリケーションのすべてのリポジトリが含まれます。
│   │   ├── Core/                                           - BaseRepo は、リポジトリをサポートする組み込み関数を含むクラスです。
│   │   │   ├── Contracts/IBaseRepo.php
│   │   │   └── BaseRepo
│   │   │           implements Contracts\IBaseRepo
│   │   ├── Contracts/I...Repo
│   │   │           extends Core\Contracts\IBaseRepo
│   │   └── ...Repo extends Core\BaseRepo
│   │               implements Contracts\I...Repo
│   ├── Rules/                                          -> アプリケーションのカスタム検証ルール オブジェクトが含まれます。
│   │   ├── Core/BaseRule
│   │   └── ...Rule.php extends Core\BaseRule
│   └── Services/                                       -> アプリケーションのすべてのサービスが含まれます。
│       ├── Core/BaseService
│       ├── Traits/
│       └── ...Service extends Core\BaseService
├── bootstrap/                                          -> フレームワークをブートストラップする `app.php` ファイルが含まれます。
│   ├── cache/...                                           - パフォーマンスを最適化するためにフレームワークで生成されたファイルが含まれています。
│   └── constants/                                          - システムによって自動的にロードされる定数を定義するファイルが含まれます。
│       ├── autoload.php
│       └── files/....php
├── config/                                             -> アプリケーションのすべての構成ファイルが含まれます。
├── database/                                           -> データベースの移行、モデル ファクトリ、およびシーダーが含まれます。
│   ├── factories/                                          - 模型工場。
│   ├── migrations/                                         - データベースの移行。
│   └── seeders/                                            - シーダー。
│       ├── Core/
│       │   └── Traits/
│       ├── Auth/...Seeder
│       └── ...
├── lang/                                               -> アプリケーションの多言語ファイルが含まれています。
├── packages/                                           -> 独自の Laravel カスタマイズ パッケージがすべて含まれています。
├── public/                                             -> `index.php` ファイルが含まれます。このファイルは、アプリケーションに入るすべてのリクエストのエントリ ポイントであり、自動ロードを構成します。
├── resources/                                          -> ビューと、CSS や JavaScript などのコンパイルされていない生のアセットが含まれます。
│   ├── css/(admin|front)/
│   ├── js/(admin|front)/
│   └── views/
│       ├── (admin|front)/
│       ├── errors/
│       └── vendor/
├── routes/                                             -> アプリケーションのすべてのルート定義が含まれます。 (ドメインごとに別: Admin / Front / API)。
│   ├── api.php
│   ├── web.php
│   ├── admin/(home|auth|...).php
│   ├── front/(home|auth|...).php
│   └── api/
│       ├── admin/(auth|user|...).php
│       └── front/(auth|user|...).php
├── storage/                                            -> ログ、コンパイルされた Blade テンプレート、ファイルベースのセッション、ファイル キャッシュ、およびフレームワークによって生成されたその他のファイルが含まれます。
├── tests/                                              -> 自動テストが含まれます。
└── vendor/                                             -> Composer の依存関係が含まれます。
```
