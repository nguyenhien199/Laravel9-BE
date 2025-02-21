# BUILD BASE-IMAGE

_(The base environment is rarely changed/upgraded, while building it takes a lot of time, so it is isolated to here and made in compliance with this document to build it.)_

**Let's start at the root of the project directory, then perform the following steps:**

## #Step 1: Moving

- From the project root directory, move:
```bash
cd ./docker/base
```

## #Step 2: Configuration

_(This step is only performed the first time when creating a Project.)_

- Copy the sample environment file and save it at the current directory (with required name `.env`).
```bash
cp .env-temp.env .env
```

- Change configuration information to match the environment, blocks:
  + `## PROJECT`
  + `## BASE IMAGE NAME`
  + `## PHP VERSION`
  + `## PHP EXTENSION OPTION INSTALL`

> 📝**NOTE:**
> - `COMPOSE_PROJECT_NAME`: Is the project name - used by Docker-Compose. This value is prepended with the service name to the container's name on startup.
> - `JV_BASE_IMAGE_NAME`: Is the name of the docker image `Base-Image` to be built (including full `repository:tag` name components).
> - `JV_PHP_VERSION`: Is the PHP version to build in the `Base-Image` docker image.
> - `JV_DISTRIBUTION`: Is the kernel version of the Debian OS that will build the `Base-Image` docker image.  
>                      Leave blank -> For the latest supported version (corresponding to the PHP version selected above - `JV_PHP_VERSION`).
> - `JV_INSTALL_...`: The value of these prefixes accepts 2 values `true/false` (lowercase) - which is a Yes/No choice for installation.
>
>> - Carefully read the notes in the copied `.env` file for better understanding.
>> - Be sure to install the appropriate PHP Extensions for the project.
>> - Do not install excess, it will lead to increased Docker image capacity - wasting resources and taking more build time.

- Save configured information in `.env` file and push to Project GIT:

> 🔥**IMPORTANT:**
>> When copying this source code into an actual Project:
>> - Configure the parameters in the `.env` file accordingly.
>> - Edit the `/docker/base/.gitignore` file (remove the `.env` part) and push the `.env` file to the Project's GIT.
>> <br/><br/>
>> ==> `The purpose is to save the configuration for the Base-Image docker image for the Project.`

## #Step 3: Build the docker image

- Build the Image with parameters (_commonly used_):
```bash
bash build.sh --no-cache --memory=512m --progress=plain
```

> 📝**NOTE:**
> - For a list of supported parameters, execute the following command:
> ```bash
> bash build.sh -h
> ```

## #Step 4: Come back

- After successfully building the docker image, execute the following command to go back to the project root directory:
```bash
cd ../../
```

# END !!!
