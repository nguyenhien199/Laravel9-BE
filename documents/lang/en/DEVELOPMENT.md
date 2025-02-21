# BUILD AND DEPLOY

_`Base-Image` is short for: `Base docker image`_  
_`App-Image` is short for: `Application docker image`_  

Documentation: Building and Deploying `App-Image` for Development environments.

**Let's start at the root of the project directory, then perform the following steps:**

## #Step 0: Initialization (Build `Base-Image`)

Have 2 way:

- Way 1: Build `Base-Image` MANUALLY - According to the following document:
  [/docker/base/BUILD-BASE.md](../../../docker/base/lang/en/BUILD-BASE.md).

- Way 2: Build `Base-Image` AUTOMATICALLY - See `#Step 3`.

> However - When first starting a project, please see the documentation at `#Way 1` to learn how to configure environment variables (`.env`) for `Base-Image`.

## #Step 1: Configure environment variable files

- Copy the environment file (required name `.env`):
```bash
cp ./.env-local.env ./.env
```

- Change configuration information to suit the environment, blocks:
    + `## SAIL CONFIGURATION FOR DEVELOPMENT ##`
    + `## SUPERVISOR TURN ON/OFF SERVICE ##`
    + `## FOR APP ##`
    + ...

> 📝**NOTES:**
> - `## SAIL CONFIGURATION FOR DEVELOPMENT ##`:
>>  + `COMPOSE_PROJECT_NAME`: Name the project(format following Docker-Compose). This value is prepended with the service name to the name of the Container on startup.
>>  + `COMPOSE_PROJECT_NETWORK`: Name the project internal network (format following Docker-Compose). This value will be created by Docker-Compose and named Network for the project.
>>  + `SAIL_FILES`: Absolute path to the `docker-compose.yml` configuration file. _(starting from the project root and NOT preceded by a `/`)_.
>>  + `APP_IMAGE_NAME`: The name of `App-Image`. _(Name it appropriately for the project, eg: `coffee/backend-app:latest`)_.
>>  + `APP_SERVICE`: The `service` name corresponding to App container is configured in the `docker-compose.yml` file.
>>  + `APP_PORT`/`APP_PORT_SSL`: Port to access the App (respectively http and https).
>>  + `SUPERVISOR_PORT`: The port will be used to access the `Supervisord` manager - which manages App's respective services/processes.
>>  + `..._TAG`: Suffixes - Corresponds to the Docker image(version) Tags of the `services` in the `docker-compose.yml` file.
>>  + `..._FORWARD`: Suffixes - Corresponds to the ports that will be used to access other services/applications configured in `services` in the `docker-compose.yml` file.
>
> - `## SUPERVISOR TURN ON/OFF SERVICE ##`:
>>  + `SUV_WEB_SERVER`:          Enable(`true`) - Disable(`false`) the `Web-Server(Nginx/Apache)` service under the management of Supervisord.
>>  + `SUV_SCHEDULER`:           Enable(`true`) - Disable(`false`) the `Scheduler(Laravel)` service under the management of Supervisord.
>>  + `SUV_SCHEDULER_NUMPROCS`:  Is the number of `Scheduler(Laravel)` processes that Supervisord will create (Default: is 0 if `SUV_SCHEDULER=false`, is 1 if `SUV_SCHEDULER=true` and is empty `SUV_SCHEDULER_NUMPROCS`).
>>  + `SUV_WORKER`:              Enable(`true`) - Disable(`false`) the `Worker(Laravel)` service under the management of Supervisord.
>>  + `SUV_WORKER_NUMPROCS`:     Is the number of `Worker(Laravel)` processes that Supervisord will create (Default: is 0 if `SUV_WORKER=false`, is 1 if `SUV_WORKER=true` and is empty `SUV_WORKER_NUMPROCS`).
>
> - `## FOR APP ##`:
>>  + The configurations in this block, are the configuration of the PHP application.
>
>> - In addition, all other configurations, can remain the same.
>> - Please read carefully the notes in the `.env` file just copied.

## #Step 2: Introduction and Installing `sail` (the command line interface)

### #Introducing `sail`

- `sail`: Is a light-weight command-line interface for interacting with Laravel's default Docker development environment.  
  View full information [here](https://laravel.com/docs/11.x/sail#introduction).

- `sail`: Is supported on macOS, Linux, and Windows (via [WSL2](https://learn.microsoft.com/en-us/windows/wsl/about)).

- `docker/sail`: In the project is a copy of Laravel Sail and adapted to the project's intended use.  
  Eg:  
    - Configure default User from `sail` to `www-data` to match permissions when using `php-fpm` and `nginx` in combination.  
      _(The original Laravel Sail is used as an integration between `ubuntu` and `apache2`.)_
    - Can interact directly with the `Base-Image` building step to simplify development steps.

### #Install `sail`

Because `sail` is a command-line interface, certain permissions need to be granted.

Executable settings for `sail`:
```bash
bash ./docker/setup_sail.sh
```

- A quick guide to the `sail` command line listing:
```bash
./docker/sail --help
```

## #Step 3: Build - Starts the application

- Build `App-Image` with parameters:
```bash
./docker/sail build --no-cache --memory=512M --progress=plain
```

> 📝**NOTES:**
> - `--no-cache` : Do not use Cache when building.
> - `--memory=512M` : Set Memory limit for the build process.
> - `--progress=plain` : View detailed build history on the Console screen.
>> **On first build or when using the `build` parameter, build of the `Base-Image` is automatically enabled - prompted at `#Step 0 / Way 2`.**  
>> Then comes the step of building the `App-Image`.

- Start the application with `sail`:
```bash
./docker/sail up -d
```

> 📝Can expand parameters:
> - `--build` : Force a rebuild of the `App-Image` - before starting the Containers.
>> **With the first build - will also automatically trigger the build of the `Base-Image` - prompted at `#Step 0 / Way 2`.**  
>> Then comes the step of building the `App-Image` and starting the Containers.

> 🔥**IMPORTANT:** 
> - If you get the error "ERROR [internal] load metadata for `docker.io/xxxyyy:latest`" please try again with `sudo` permissions.

## #Expansion: 

- Login to App bash (with user: `www-data`):
```bash
./docker/sail bash
```

- Login to App bash (with user: `root`):
```bash
./docker/sail root-bash
```

- Install dependencies for PHP:
```bash
./docker/sail composer install --optimize-autoloader
```
