# BUILD AND DEPLOY - TESTING

Documentation: Building and Deploying for Testing environment.

**📝Follow the instructions in the document: [Build and deploy for Production environment](./PRODUCTION.md).**

And notice the following differences:

- In the section `#Step 1: Build App-Image`: 
  Instead of using the Bash script in the `docker/production` directory, for the new Testing environment use the Bash script in the `docker/testing` directory. 
  _(The parameters in the script remain the same)_.
   ```bash
   'bash ./docker/production/build.sh ...'
   ->
   'bash ./docker/testing/build.sh ...'
   ```

- In the section `#Build and Deploy ... - Using Bash Script.` -> `#Server configuration` -> `3. Create (or upload) an environment variable configuration file ...`: 
  Instead of naming the file `production.env`, name the file `testing.env` corresponding to the environment name to avoid confusion.


- In the section `#Build and Deploy ... - Using Bash Script.` -> `#Server configuration` -> `7. Configure parameters in Script ~/project/bash_deploy_script.sh`: 
  The `SOURCE_TO_BUILD="testing"` parameter is required.
  Additionally, the remaining parameters need to be set appropriately for your Testing environment.
