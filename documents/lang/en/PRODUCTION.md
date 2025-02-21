# BUILD AND DEPLOY - PRODUCTION

_`Base-Image` is short for: `Base Docker image`_  
_`App-Image` is short for: `Application Docker image`_  

Documentation: Building and Deploying `App-Image` for Production environment.

> Prerequisites: Make sure the Production Server has the Unix Shell(`bash`), Docker Engine, and Docker-Compose (including the Docker Compose plugin) installed.

## #Build `App-Image` - Manually

**Let's start at the root of the project directory, then perform the following steps:**

### #Step 0: Initialization (Build `Base-Image`)

Have 2 way:

- Way 1: Build `Base-Image` MANUALLY - According to the following document:
  [/docker/base/BUILD-BASE.md](../../../docker/base/lang/en/BUILD-BASE.md).

- Way 2: Build `Base-Image` AUTOMATICALLY - See `#Step 1`.

> However - When first starting a project, please see the documentation at `#Way 1` to learn how to configure environment variables (`.env`) for `Base-Image`.

### #Step 1: Build `App-Image`

- Build `App-Image` with parameters:
```bash
bash ./docker/production/build.sh --no-cache --memory=512m --progress=plain
```

> 📝Can expand parameters:
> - `--no-cache`: Do not use Docker Cache when building.
> - `--memory=512M` : Configure Memory limit when building.
> - `--progress=plain` : View detailed build history on the Console screen.
> - `--build-base`: Force a rebuild of the `Base-Image`.
> - `--name=NAME`: Name for the `App-Image`.  
>    _(When building a project for the first time, you should edit the variable `PROD_IMAGE_REPO` in the script `/docker/production/build.sh` to set the default name for the `App-Image`, avoiding the need to pass this parameter frequently.)_
> - `--tag=TAG`: Tag for `App-Image`.
>> **On first build or when using the `--build-base` parameter, build of the base image (Base-Image) is automatically enabled - prompted at `#Step 0 / Way 2`.**  
>> Then comes the step of building the `App-Image`.

- To see all supported parameters, execute the following command:
```bash
bash ./docker/production/build.sh -h
```

## #Deploy `App-Image` to Production environment - Manually.

> `App-Image` has been completely built in the above step.  
> 
> To deploy a Docker image to a Linux kernel host with Docker Engine installed in the usual way, 
> please learn the [docker run](https://docs.docker.com/reference/cli/docker/container/run) command.

## #Build and Deploy `App-Image` to Production environment - Using Bash Script.

In the source code, there is a template file `/docker/common/templates/bash_deploy_script.sh`.  
There are main processing contents as follows:

- Interact with GIT _(Switch branch/Get latest code/Go to a specified Commit ID)_ to package the source code into `App-Image`.
- Forward command to `/docker/production/build.sh` - to execute `App-Image` build command. _(Described in section `#Build App-Image - Manually.` above)_.
- Delete the old Container from the Docker system.
- Create a new Container based on the newly built `App-Image` _(There are parameters for selection)_.
- Delete old Docker images (images without name) and clear Cache _(There are parameters for selection)_.

### #Production Server configuration

> The following steps are performed only once - during the first deployment.

1. Create Project folder on Server. (For example: directory path `~/project`).  
   + `mkdir ~/project` -> Project folder.
   + `mkdir ~/project/source` -> Source code directory.
   + `mkdir ~/project/warehouses` -> Warehouses directory.
   + `mkdir ~/project/configs` -> Directory of configuration files.

2. Upload the template file `bash_deploy_script.sh` to the newly created directory: `~/project/bash_deploy_script.sh`.

3. Create (or upload) an environment variable configuration file (`~/project/configs/production.env`) - and configure the appropriate environment variables for the project.

4. Configure SSH-Key on Git Server (Git website) - Because the Script interacts with GIT through authentication with SSH-Key.  
   _Refer to Gitlab's instructions [here](https://docs.gitlab.com/ee/user/ssh.html)._  
   📝 _(If you use GIT authentication with Username/Password every time you do a deployment, skip this step.)_

5. Upload the newly created SSH Private Key file to the Server - should be stored in the `~/.ssh` directory corresponding to the User who is ssh.  
   📝 _(If you use GIT authentication with Username/Password every time you do a deployment, skip this step.)_

6. Initialize and Pull the source code for the first time to the Server (Using `git clone`) - to the newly created directory: `~/project/source`.

7. Configure parameters in Script `~/project/bash_deploy_script.sh`.

   - `SOURCE_TO_BUILD`: The subdirectory name in the Docker directory, containing the Bash script `build.sh` to execute the `App-Image` build.
   - `PWD_WORKDIR`: Directory path containing the source code (`~/project/source`) just created.
   - `PWD_WAREHOUSE`: The repository directory path (`~/project/warehouses`) just created.
   - `ENV_FILE`: Path of the environment variable configuration file (`~/project/configs/production.env`) just created.
   - 
   - `GIT_REMOTE_URL`: The URL of the Git repository to use to pull the source code.
   - `GIT_REMOTE_NAME`: The Git Remote name to use to pull the source code (default `origin`).
   - `GIT_BRANCH_NAME`: Default Branch name for building `App-Image` (default `master`).
   - `GIT_SSH_KEY`: SSH Private Key file path (`~/.ssh/...`) just uploaded _(If using Username/Password for authentication -> Leave blank)_.
   - 
   - `PROJECT_NETWORK`: The network name in Docker that the `App-Image` Container will bind to _(If you don't want to bind -> Leave blank)_.
   - `APP_IMAGE_REPO`: Set a default Name for the `App-Image` to be built (Set as appropriate for the project, e.g. `coffee/backend-app`) **🔥Note: DO NOT include the TAG part of an Image**.
   - `APP_IMAGE_TAG`: Set default Tag for `App-Image` - used to mark built versions, e.g. `latest`.
   - `APP_CONTAINER_NAME`: Name the Container when deploying the `App-Image`.
   - 
   - `APP_PORT_HTTP`/`APP_PORT_HTTPS`: Corresponding to the 2 Ports that will be used to access the respective application of the App Container (http and https) _(If you don't want to forward ports -> Leave blank)_.
   - `SUPERVISOR_PORT`: The port will be used to access the `Supervisord` manager - which manages the App Container's respective services/processes _(If you don't want to forward ports -> Leave blank)_.
   - 
   - `PWD_WAREHOUSE_...`: The directory path will be mounted to the corresponding directories in the `App-Image` Container _(If you don't want to link -> Leave blank)_.
   - `PWD_CONTAINER_...`: The directory path in the Container of the `App-Image` that will be mounted _(Please specify the exact path)_.
   > - 🔥All folder/file paths in this step -> MUST USE ABSOLUTE PATH.
   > - 🔥Otherwise, all other configurations not mentioned remain the same.

### #Bash Script Execution - Continuous Deployment

- Build - Deploy with parameters:
```bash
# eg:
bash ~/project/bash_deploy_script.sh --no-cache --memory=512m --progress=plain --rmi
```

- To see all supported parameters, execute the following command:
```bash
bash ~/project/bash_deploy_script.sh -h
```
