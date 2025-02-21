# SOURCE CODE STRUCTURE

_Any structural changes to the source code will be updated in this document._

> The project's source code directory structure is divided into 2 components:
> - #Base directory structure.
> - #Source code structure based on Framework.

## #Base directory structure:

```text
boilerplate/
├── docker/    -> Contains all installation configurations, Development/Production environment build scripts for Docker-based project.
└── documents/ -> Contains all definition/description documents for the project.
```

## #Source code structure based on Framework.
**(Here is Laravel Framework)**

- Laravel Framework's root directory structure is described on the home page: https://laravel.com/docs/10.x/structure
- 
- Below is the updated structure description tree based on Laravel Framework:

```text
laravel/
├── app/
│   ├── Console/                                        -> Contains all of the custom Artisan Commands.
│   ├── Constants/                                      -> Contains self-defined Constants.
│   ├── Enums/                                          -> Contains Enum classes.
│   ├── Events/                                         -> Contains Event classes.
│   │   ├── Core/BaseEvent.php
│   │   └── ...Event extends Core\BaseEvent
│   ├── Exceptions/...Exception.php                     -> Contains your application's exception Handler and any Exceptions thrown by application.
│   ├── Helpers/                                        -> Contains custom Helpers:
│   │   ├── Global/...Helper.php  (autoload)                - Files in this directory whose name includes the word `xxxHelper.php` at the end will be automatically loaded by `HelperServiceProvider` (so they are available as global functions).
│   │   └── ...Helper.php         (not autoload)            - If you do not want a particular helper file loaded globally, place them outside the `Helpers/Global` directory.
│   ├── Http/                                           -> Contains your controllers, middleware, and form requests.
│   │   ├── Controllers/                                    - All controllers.
│   │   │   ├── Core/BaseController                             + Base controller for all.
│   │   │   ├── Admin/
│   │   │   │   ├── Core/BaseAdminController                    + Base controller for Admin(CMS) domain controllers.
│   │   │   │   └── ...Controller
│   │   │   │          extends Core\BaseAdminController
│   │   │   ├── Api/
│   │   │   │   ├── Admin/
│   │   │   │   │   ├── Core/BaseApiAdminController             + Base controller for Admin(CMS-App) API domain controllers.
│   │   │   │   │   └── ...Controller
│   │   │   │   │          extends Core\BaseApiAdminController
│   │   │   │   └── Front/
│   │   │   │       ├── Core/BaseApiFrontController             + Base controller for Front(Client-App) API domain controllers.
│   │   │   │       └── ...Controller
│   │   │   │              extends Core\BaseApiFrontController
│   │   │   └── Front/
│   │   │       ├── Core/BaseFrontController                    + Base controller for Front(Web) domain controllers.
│   │   │       └── ...Controller
│   │   │              extends Core\BaseFrontController
│   │   ├── Middleware/                                     - Middleware.
│   │   ├── Parameters/                                     - Swagger Parameter Schemas.
│   │   ├── Requests/                                       - Form request - Swagger Form Request Schemas.
│   │   │   ├── Core                                            + Define Base-FormRequests corresponding to 2 Web/API domains.
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
│   │   ├── Resources/                                      - Return object definitions (DTOs) - Swagger Client Return Data Object Schemas.
│   │   └── Responses/                                      - Return form definitions - The Structural Schemas returned to Swagger's Client.
│   │       └── Traits/                                         + Traits describe the structure/form returned for requests from the Client.
│   │           ├── Core/BaseResult
│   │           └── Api|WebResult use Core\BaseResult
│   ├── Jobs/                                           -> Contains the queueable jobs for your application.
│   ├── Listeners/                                      -> Contains the classes that handle your events.
│   ├── Mail/                                           -> Contains all of your classes that represent emails sent by your application.
│   ├── Models/                                         -> Contains all of your Eloquent Model classes.
│   │   ├── Core                                            - BaseAuthModel|BaseModel|BasePivot are base Models (define the common structure for Models).
│   │   │   ├── BaseAuthModel|BaseModel|BasePivot
│   │   │   └── Traits/...
│   │   ├── Traits/                                         - Traits define extensions for Models (To separate the purpose and shorten the Model file).
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
│   ├── Notifications/                                  -> Contains all of the `transactional` notifications that are sent by your application.
│   ├── Observers/                                      -> Contains all the application's observers.
│   ├── Policies/                                       -> Contains the authorization policy classes for your application.
│   ├── Providers/                                      -> Contains all of the service providers for your application.
│   ├── Repositories/                                   -> Contains all Repositories for the application.
│   │   ├── Core/                                           - BaseRepo is a class that contains built-in functions that support the Repository.
│   │   │   ├── Contracts/IBaseRepo.php
│   │   │   └── BaseRepo
│   │   │           implements Contracts\IBaseRepo
│   │   ├── Contracts/I...Repo
│   │   │           extends Core\Contracts\IBaseRepo
│   │   └── ...Repo extends Core\BaseRepo
│   │               implements Contracts\I...Repo
│   ├── Rules/                                          -> Contains the custom validation rule objects for your application.
│   │   ├── Core/BaseRule
│   │   └── ...Rule.php extends Core\BaseRule
│   └── Services/                                       -> Contains all Services for the application.
│       ├── Core/BaseService
│       ├── Traits/
│       └── ...Service extends Core\BaseService
├── bootstrap/                                          -> Contains the `app.php` file which bootstraps the framework.
│   ├── cache/...                                           - Contains framework generated files for performance optimization.
│   └── constants/                                          - Contains files that define Constants that are automatically loaded by the system.
│       ├── autoload.php
│       └── files/....php
├── config/                                             -> Contains all of your application's configuration files.
├── database/                                           -> Contains your Database migrations, Model factories, and Seeders.
│   ├── factories/                                          - Model factories.
│   ├── migrations/                                         - Database migrations.
│   └── seeders/                                            - Seeders.
│       ├── Core/
│       │   └── Traits/
│       ├── Auth/...Seeder
│       └── ...
├── lang/                                               -> Contains multilingual files for the application.
├── packages/                                           -> Contains all your own Laravel customization packages.
├── public/                                             -> Contains the `index.php` file, which is the entry point for all requests entering your application and configures autoloading.
├── resources/                                          -> Contains your views as well as your raw, un-compiled assets such as CSS or JavaScript.
│   ├── css/(admin|front)/
│   ├── js/(admin|front)/
│   └── views/
│       ├── (admin|front)/
│       ├── errors/
│       └── vendor/
├── routes/                                             -> Contains all of the route definitions for your application. (Separate for domains: Admin / Front / API).
│   ├── api.php
│   ├── web.php
│   ├── admin/(home|auth|...).php
│   ├── front/(home|auth|...).php
│   └── api/
│       ├── admin/(auth|user|...).php
│       └── front/(auth|user|...).php
├── storage/                                            -> Contains logs, compiled Blade templates, file-based sessions, file caches, and other files generated by the framework.
├── tests/                                              -> Contains your automated tests.
└── vendor/                                             -> Contains Composer dependencies.
```
