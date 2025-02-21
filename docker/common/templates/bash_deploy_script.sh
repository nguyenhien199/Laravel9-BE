#!/usr/bin/env bash

## Show help: bash /path/bash_deploy_script.sh -h

## Base dirname.
PWD_HERE=$(dirname -- "$0")

## PARAMETER CONFIGURATION #################################
# The subdirectory name in the Docker directory,
# containing the Bash script `build.sh` to execute the `App-Image` build.
SOURCE_TO_BUILD="production"
# Root Source directory.
PWD_WORKDIR="/path/.../source"
# Warehouse (Storage/Logs) directory.
PWD_WAREHOUSE="/path/.../warehouses"
# ENV file path.
ENV_FILE="/path/.../production.env"

## GIT
GIT_REMOTE_URL="https://gitlab.com/project/backend.git"
GIT_REMOTE_NAME="origin"
GIT_BRANCH_NAME="master"
# (To use Username/Password authentication, set GIT_SSH_KEY empty).
GIT_SSH_KEY="/path/.../ssh_private_key"

## DOCKER IMAGE + CONTAINER
# (Don't want to configure network for the project, set PROJECT_NETWORK blank).
PROJECT_NETWORK="project_network"
APP_IMAGE_REPO="project/backend-app"
APP_IMAGE_TAG="latest"
APP_CONTAINER_NAME="project-backend"
# (Don't want port forwarding, leave it blank).
APP_PORT_HTTP=80
APP_PORT_HTTPS=443
SUPERVISOR_PORT=9001

## SHARED FOLDER (MOUNT VOLUME)
# Server directory.
# (Don't want to use folder sharing, leave blank).
PWD_WAREHOUSE_STORAGE="${PWD_WAREHOUSE}/storage"
PWD_WAREHOUSE_SESSION="${PWD_WAREHOUSE}/sessions"
PWD_WAREHOUSE_CACHE="${PWD_WAREHOUSE}/cache"
PWD_WAREHOUSE_UPLOAD="${PWD_WAREHOUSE}/uploads"
PWD_WAREHOUSE_APP_LOG="${PWD_WAREHOUSE}/logs/app"
PWD_WAREHOUSE_PHP_LOG="${PWD_WAREHOUSE}/logs/php"
PWD_WAREHOUSE_NGINX_LOG="${PWD_WAREHOUSE}/logs/nginx"
PWD_WAREHOUSE_SUPER_LOG="${PWD_WAREHOUSE}/logs/supervisor"
## Container directory (Default for Laravel).
PWD_CONTAINER_STORAGE="/var/www/html/storage"
PWD_CONTAINER_SESSION="/var/www/html/storage/framework/sessions"
PWD_CONTAINER_CACHE="/var/www/html/storage/framework/cache/data"
PWD_CONTAINER_UPLOAD="/var/www/html/storage/app/public"
PWD_CONTAINER_APP_LOG="/var/www/html/storage/logs"
PWD_CONTAINER_PHP_LOG="/var/log/php"
PWD_CONTAINER_NGINX_LOG="/var/log/nginx"
PWD_CONTAINER_SUPER_LOG="/var/log/supervisor"
## END: PARAMETER CONFIGURATION ############################

## DEFAULT DATA DEFINITION #################################
## GIT
GIT_LATEST_FLAG=1
GIT_USE_FLAG=0
GIT_AUTH_USE="KEY"
GIT_COMMIT_ID=""
GIT_USER=""
GIT_PASS=""
ARGS=()
## DOCKER
DOCKER_BUILD_FLAG=1
DOCKER_DEPLOY_FLAG=1
DOCKER_RMI_FLAG=0
DOCKER_PRUNE_FLAG=0
## END: DEFAULT DATA DEFINITION ############################

## FUNCTION DEFINITION #####################################
## First definition function.
# Usage: initial;
function initial() {
  # Determine if stdout is a terminal...
  if [[ -t 1 ]]; then
    # Determine if colors are supported...
    COLORS=$(tput colors)
    if [[ -n "${COLORS}" ]] && [[ "${COLORS}" -ge 8 ]]; then
      # https://linuxcommand.org/lc3_adv_tput.php
      BLACK="$(tput setaf 0)"
      RED="$(tput setaf 1)"
      GREEN="$(tput setaf 2)"
      YELLOW="$(tput setaf 3)"
      BLUE="$(tput setaf 4)"
      MAGENTA="$(tput setaf 5)"
      CYAN="$(tput setaf 6)"
      WHITE="$(tput setaf 7)"
      BOLD="$(tput bold)"
      REVERSE="$(tput smso)"
      UNDERLINE="$(tput smul)"
      NC="$(tput sgr0)" # NORMAL COLOR
    fi
  fi
}

## Show Info message function.
# Usage: display_info "Message to display";
function display_info() {
  echo
  echo "  ${BLUE}[INFO] $@ ${NC}" >&1
  echo
}

## Show Command function.
# Usage: display_command "Command content to display";
function display_command() {
  echo "${RED}+ $@ ${NC}" >&1
}

## Show Error message function.
# Usage: display_error "Error message to display";
function display_error() {
  echo
  echo "  ${RED}[ERROR] $@ ${NC}" >&2
  echo
  exit 1
}

## Show Help function.
# Usage: display_help;
function display_help() {
  echo
  echo "${YELLOW}Usage:${NC}"
  echo "  bash $0 [OPTIONS]"
  echo
  echo "${YELLOW}Options:${NC}"
  echo "  ${GREEN}-h, --help${NC}                   Show help."
  echo
  echo "      ${GREEN}--git-branch=BRANCH${NC}      Git: Checkout to the Branch (default: '${GIT_BRANCH_NAME}')."
  echo "      ${GREEN}--git-commit=COMMIT_ID${NC}   Git: Checkout to the Commit ID (default: none)."
  echo "      ${GREEN}--git-latest=true${NC}        Git: Latest pull --rebase (true, false) (default: true)."
  echo "      ${GREEN}--git-user=${NC}              Git: Account username (if authenticating with an account) (default: blank)."
  echo "      ${GREEN}--git-pass=${NC}              Git: Account password (if authenticating with an account) (default: blank)."
  echo
  echo "      ${GREEN}--build-base${NC}             Force build docker Base-Image."
  echo
  echo "      ${GREEN}--name=NAME${NC}              Name the Image (default: '${APP_IMAGE_REPO}')."
  echo "      ${GREEN}--tag=TAG${NC}                Tag the Image (default: '${APP_IMAGE_TAG}')."
  echo "      ${GREEN}--no-cache${NC}               Do not use Caching when building Images."
  echo "      ${GREEN}--memory=BYTES${NC}           Set Memory limit for Image building process (eg: 512M or 1G) (default: 512M). Not supported by BuildKit."
  echo "      ${GREEN}--progress=STRING${NC}        Set type of progress output (auto, tty, plain, quiet) (default: auto)."
  echo
  echo "      ${GREEN}--no-build${NC}               Docker: Do not build Images."
  echo "      ${GREEN}--no-deploy${NC}              Docker: Do not deploy Containers."
  echo "      ${GREEN}--rmi${NC}                    Docker: Force deletion of unnamed Images after deployment."
  echo "      ${GREEN}--prune${NC}                  Docker: Clear the Cache after building the Image."
  echo
  exit 1
}

## Execute Command function.
# Usage: exec_command "Command to execute";
function exec_command() {
  if [[ $# -gt 0 ]]; then
    display_command "$@"
    eval "$@"
  fi
}

## Argument Validation function.
# Usage: validation "$@";
function validation() {
  while [[ $# -gt 0 ]]; do
    case "$1" in
      -h|help|-help|--help)
        display_help
        shift ;;
      --git-branch=*)
        local git_branch="$(echo $1 | sed -e 's/^[^=]*=//g')"
        if [[ -n "${git_branch}" ]]; then
          GIT_USE_FLAG=1
          GIT_BRANCH_NAME="${git_branch}"
        fi
        shift ;;
      --git-commit=*)
        local git_commit="$(echo $1 | sed -e 's/^[^=]*=//g')"
        if [[ -n "${git_commit}" ]]; then
          GIT_USE_FLAG=1
          GIT_COMMIT_ID="${git_commit}"
        fi
        shift ;;
      --git-latest|--git-latest=true)
        GIT_USE_FLAG=1
        GIT_LATEST_FLAG=1
        shift ;;
      --git-latest=false)
        GIT_LATEST_FLAG=0
        shift ;;
      --git-user=*)
        local git_user="$(echo $1 | sed -e 's/^[^=]*=//g')"
        if [[ -n "${git_user}" ]]; then
          GIT_USER="${git_user}"
        fi
        shift ;;
      --git-pass=*)
        local git_pass="$(echo $1 | sed -e 's/^[^=]*=//g')"
        if [[ -n "${git_pass}" ]]; then
          GIT_PASS="${git_pass}"
        fi
        shift ;;
      --build-base|--build-base=true)
        ARGS+=("--build-base")
        shift ;;
      --name=*)
        local image_repo="$(echo $1 | sed -e 's/^[^=]*=//g')"
        if [[ -n "${image_repo}" ]]; then
          APP_IMAGE_REPO="${image_repo}"
        fi
        shift ;;
      --tag=*)
        local image_tag="$(echo $1 | sed -e 's/^[^=]*=//g')"
        if [[ -n "${image_tag}" ]]; then
          APP_IMAGE_TAG="${image_tag}"
        fi
        shift ;;
      --no-cache|--no-cache=true)
        ARGS+=("--no-cache")
        shift ;;
      --memory=*)
        local memory="$(echo $1 | sed -e 's/^[^=]*=//g')"
        if [[ -n "${memory}" ]]; then
          ARGS+=("--memory=${memory}")
        else
          ARGS+=("--memory=512M")
        fi
        shift ;;
      --progress=*)
        local progress="$(echo $1 | sed -e 's/^[^=]*=//g')"
        if [[ -n "${progress}" ]]; then
          ARGS+=("--progress=${progress}")
        else
          ARGS+=("--progress=auto")
        fi
        shift ;;
      --no-build|--no-build=true)
        DOCKER_BUILD_FLAG=0
        shift ;;
      --no-deploy|--no-deploy=true)
        DOCKER_DEPLOY_FLAG=0
        shift ;;
      --rmi|--rmi=true)
        DOCKER_RMI_FLAG=1
        shift ;;
      --prune|--prune=true)
        DOCKER_PRUNE_FLAG=1
        shift ;;
      *)
        display_error "Argument '$1' is not defined!"
        shift ;;
    esac
  done

  # Set Use GIT flag.
  if [[ ${GIT_LATEST_FLAG} -eq 1 ]]; then
    GIT_USE_FLAG=1
  fi
  # Check WORKDIR directory exist.
  if [[ ! -d "${PWD_WORKDIR}" ]]; then
    display_error "WORKDIR: '${PWD_WORKDIR}' directory does not exist!"
  fi
  # Check BASH SCRIPT file exist.
  if [[ ! -f "${PWD_WORKDIR}/docker/${SOURCE_TO_BUILD}/build.sh" ]]; then
    display_error "SCRIPT: '/docker/${SOURCE_TO_BUILD}/build.sh' file does not exist!"
  fi
  # Check WAREHOUSE directory exist.
  if [[ ! -d "${PWD_WAREHOUSE}" ]]; then
    display_error "WAREHOUSE: '${PWD_WAREHOUSE}' directory does not exist!"
  else
   chmod 777 ${PWD_WAREHOUSE} 2>/dev/null
  fi
  # Check ENV file exist.
  if [[ ! -f "${ENV_FILE}" ]]; then
    display_error "ENV: '${ENV_FILE}' file does not exist!"
  fi
  # Check GIT Authentication Account if used.
  if [[ ${GIT_USE_FLAG} -eq 1 ]]; then
    # GIT: Check SSH-Key file exist.
    if [[ -z "${GIT_SSH_KEY}" ]] || [[ ! -f "${GIT_SSH_KEY}" ]]; then
      GIT_AUTH_USE="ACC"
      # Check GIT Authentication Account.
      if [[ -z "${GIT_USER}" ]] || [[ -z "${GIT_PASS}" ]]; then
        display_error "GIT: Authentication account is empty. '--git-user=...' and '--git-pass=...' parameters are required!"
      fi
    fi
  fi
}

## BEGIN #######################################################################
initial
validation "$@"

if [[ -n "${APP_IMAGE_REPO}" ]]; then
  ARGS+=("--name=${APP_IMAGE_REPO}")
fi
if [[ -n "${APP_IMAGE_TAG}" ]]; then
  ARGS+=("--tag=${APP_IMAGE_TAG}")
fi
# Set App-Image name.
APP_IMAGE_NAME="${APP_IMAGE_REPO}:${APP_IMAGE_TAG}"

# WORKDIR
display_info "__START__"
exec_command "cd ${PWD_WORKDIR}"

## BEGIN: GIT PROCESS ######################################
# GIT: Current config.
GIT_CURRENT_REMOTE_URL=""
GIT_CURRENT_BRANCH_NAME=$(git rev-parse --abbrev-ref HEAD)
GIT_CURRENT_COMMIT_ID=$(git rev-parse HEAD)

GIT_REMOTE_EXISTS=$(echo $(git remote 2>&1 | grep -e "^\(${GIT_REMOTE_NAME}\)$"))
if [[ -n "${GIT_REMOTE_EXISTS}" ]]; then
  GIT_CURRENT_REMOTE_URL=$(git remote get-url ${GIT_REMOTE_NAME})
fi

# GIT: Reset current Remote function.
# Usage: reset_git_remote;
function reset_git_remote() {
  if [[ -n "${GIT_REMOTE_EXISTS}" ]]; then
    display_info "GIT: Resetting the current Remote:"
    exec_command "git remote set-url ${GIT_REMOTE_NAME} '${GIT_CURRENT_REMOTE_URL}'"
    echo
  else
    if [[ -n "$(echo $(git remote 2>&1 | grep -e "^\(${GIT_REMOTE_NAME}\)$"))" ]]; then
      display_info "GIT: Resetting the current Remote:"
      exec_command "git remote remove ${GIT_REMOTE_NAME}"
      echo
    fi
  fi
}

# GIT: Reset current Branch/Commit function.
# Usage: reset_git;
function reset_git() {
  reset_git_remote
  if [[ ${GIT_USE_FLAG} -eq 1 ]]; then
    display_info "GIT: The process encountered an error, resetting current Branch/Commit:"
    # Reset GIT to the current Branch.
    if [[ -n "${GIT_CURRENT_BRANCH_NAME}" ]]; then
      exec_command "git checkout ${GIT_CURRENT_BRANCH_NAME}"
    fi
    # Reset GIT to the current Commit.
    if [[ -n "${GIT_CURRENT_COMMIT_ID}" ]]; then
      exec_command "git reset --hard ${GIT_CURRENT_COMMIT_ID}"
    fi
    echo
  fi
}

if [[ ${GIT_USE_FLAG} -eq 1 ]]; then
  # GIT: Configuration...
  display_info "GIT: Configuration... :"

  if [[ "${GIT_AUTH_USE}" == "KEY" ]]; then
    # SSH: Chmod SSH-Key + Start Agent + Add SSH-Key.
    exec_command "chmod 600 ${GIT_SSH_KEY}"
    exec_command "ssh-agent"
    exec_command "ssh-add ${GIT_SSH_KEY}"
  elif [[ "${GIT_AUTH_USE}" == "ACC" ]]; then
    GIT_REMOTE_URL="$(echo ${GIT_REMOTE_URL} | sed -e "s/\/\//\/\/${GIT_USER}:${GIT_PASS}@/g")"
  else
    display_error "GIT: Authentication type is not defined!"
  fi

  # GIT: Set remote.
  if [[ -n "${GIT_REMOTE_EXISTS}" ]]; then
    exec_command "git remote set-url ${GIT_REMOTE_NAME} '${GIT_REMOTE_URL}'"
  else
    exec_command "git remote add ${GIT_REMOTE_NAME} '${GIT_REMOTE_URL}'"
  fi
  # GIT: Set config file mode.
  exec_command "git config core.filemode false"

  # GIT: Check Authenticate (Trick: using double command).
  if [[ "$(echo $(git fetch ${GIT_REMOTE_NAME} 2>&1))" != "" ]] && [[ "$(echo $(git fetch ${GIT_REMOTE_NAME} 2>&1))" != "" ]]; then
    reset_git_remote
    display_error "GIT: Authentication failed!"
  fi

  # GIT: Stash.
  exec_command "git stash"

  # GIT: Check Branch exist.
  if [[ $(git ls-remote --heads ${GIT_REMOTE_NAME} ${GIT_BRANCH_NAME} | wc -l) -eq 0 ]]; then
    display_error "GIT: Branch '${GIT_BRANCH_NAME}' does not exist!"
  fi

  # GIT: Fetch Branch.
  if [[ -z "$(git show-ref --heads ${GIT_BRANCH_NAME})" ]]; then
    exec_command "git fetch ${GIT_REMOTE_NAME} ${GIT_BRANCH_NAME}"
  fi

  # GIT: Checkout to Branch.
  if [[ "$(git name-rev --name-only HEAD)" != "${GIT_BRANCH_NAME}" ]]; then
    exec_command "git checkout ${GIT_BRANCH_NAME}"
  fi

  # GIT: Pull --rebase latest.
  if [[ ${GIT_LATEST_FLAG} -eq 1 ]] || [[ -n "${GIT_COMMIT_ID}" ]]; then
    display_info "GIT: Pull latest Branch '${GIT_BRANCH_NAME}':"
    exec_command "git pull ${GIT_REMOTE_NAME} ${GIT_BRANCH_NAME} --rebase"
    if [[ "$?" != "0" ]]; then
      reset_git
      display_error "GIT: Latest pull failed!"
    fi

    # GIT: Reset hard to Commit ID.
    if [[ -n "${GIT_COMMIT_ID}" ]]; then
      display_info "GIT: Check existence of Commit ID '${GIT_COMMIT_ID}':"
      if [[ -n "$(git log | grep ^"commit ${GIT_COMMIT_ID}"\$)" ]]; then
        exec_command "git reset --hard ${GIT_COMMIT_ID}"
      else
        reset_git
        display_error "GIT: Commit ID '${GIT_COMMIT_ID}' does not exist!"
      fi
    fi
  fi

  # GIT: Reset to the current Remote URL.
  reset_git_remote
fi
## END: GIT PROCESS ########################################

## BEGIN: BUILD APP-IMAGE ##################################
if [[ ${DOCKER_BUILD_FLAG} -eq 1 ]]; then
  ARGS_STR="${ARGS[@]}"

  display_info "DOCKER: Build App-Image with defined arguments:"
  display_command "bash /docker/${SOURCE_TO_BUILD}/build.sh ${ARGS_STR}"
  bash ${PWD_WORKDIR}/docker/${SOURCE_TO_BUILD}/build.sh ${ARGS_STR}
  if [[ $? -ne 0 ]]; then
    reset_git
    exit 1;
  fi
fi
## END: BUILD APP-IMAGE ####################################

## BEGIN: DEPLOY CONTAINER #################################
if [[ ${DOCKER_DEPLOY_FLAG} -eq 1 ]]; then
  ## Create and chmod Something directory.
  display_info "WAREHOUSE: Setting up shared folders:"
  # Application Storage.
  if [[ -n "${PWD_WAREHOUSE_STORAGE}" ]]; then
    exec_command "mkdir -p ${PWD_WAREHOUSE_STORAGE}"
    exec_command "chmod 777 -R ${PWD_WAREHOUSE_STORAGE} 2>/dev/null"
    PWD_MOUNTED_STORAGE_STR="-v ${PWD_WAREHOUSE_STORAGE}:${PWD_CONTAINER_STORAGE}"
  fi
  # Application Session.
  if [[ -n "${PWD_WAREHOUSE_SESSION}" ]]; then
    exec_command "mkdir -p ${PWD_WAREHOUSE_SESSION}"
    exec_command "chmod 777 -R ${PWD_WAREHOUSE_SESSION} 2>/dev/null"
    PWD_MOUNTED_SESSION_STR="-v ${PWD_WAREHOUSE_SESSION}:${PWD_CONTAINER_SESSION}"
  fi
  # Application Cache.
  if [[ -n "${PWD_WAREHOUSE_CACHE}" ]]; then
    exec_command "mkdir -p ${PWD_WAREHOUSE_CACHE}"
    exec_command "chmod 777 -R ${PWD_WAREHOUSE_CACHE} 2>/dev/null"
    PWD_MOUNTED_CACHE_STR="-v ${PWD_WAREHOUSE_CACHE}:${PWD_CONTAINER_CACHE}"
  fi
  # Application Upload.
  if [[ -n "${PWD_WAREHOUSE_UPLOAD}" ]]; then
    exec_command "mkdir -p ${PWD_WAREHOUSE_UPLOAD}"
    exec_command "chmod 777 -R ${PWD_WAREHOUSE_UPLOAD} 2>/dev/null"
    PWD_MOUNTED_UPLOAD_STR="-v ${PWD_WAREHOUSE_UPLOAD}:${PWD_CONTAINER_UPLOAD}"
  fi
  # Application Framework Log.
  if [[ -n "${PWD_WAREHOUSE_APP_LOG}" ]]; then
    exec_command "mkdir -p ${PWD_WAREHOUSE_APP_LOG}"
    exec_command "chmod 777 -R ${PWD_WAREHOUSE_APP_LOG} 2>/dev/null"
    PWD_MOUNTED_APP_LOG_STR="-v ${PWD_WAREHOUSE_APP_LOG}:${PWD_CONTAINER_APP_LOG}"
  fi
  # Application PHP Log.
  if [[ -n "${PWD_WAREHOUSE_PHP_LOG}" ]]; then
    exec_command "mkdir -p ${PWD_WAREHOUSE_PHP_LOG}"
    exec_command "chmod 777 -R ${PWD_WAREHOUSE_PHP_LOG} 2>/dev/null"
    PWD_MOUNTED_PHP_LOG_STR="-v ${PWD_WAREHOUSE_PHP_LOG}:${PWD_CONTAINER_PHP_LOG}"
  fi
  # Application Nginx Log.
  if [[ -n "${PWD_WAREHOUSE_NGINX_LOG}" ]]; then
    exec_command "mkdir -p ${PWD_WAREHOUSE_NGINX_LOG}"
    exec_command "chmod 777 -R ${PWD_WAREHOUSE_NGINX_LOG} 2>/dev/null"
    PWD_MOUNTED_NGINX_LOG_STR="-v ${PWD_WAREHOUSE_NGINX_LOG}:${PWD_CONTAINER_NGINX_LOG}"
  fi
  # Application Supervisor Log.
  if [[ -n "${PWD_WAREHOUSE_SUPER_LOG}" ]]; then
    exec_command "mkdir -p ${PWD_WAREHOUSE_SUPER_LOG}"
    exec_command "chmod 777 -R ${PWD_WAREHOUSE_SUPER_LOG} 2>/dev/null"
    PWD_MOUNTED_SUPER_LOG_STR="-v ${PWD_WAREHOUSE_SUPER_LOG}:${PWD_CONTAINER_SUPER_LOG}"
  fi
  # Set Docker parameters.
  if [[ -n "${APP_PORT_HTTP}" ]]; then FW_APP_PORT_HTTP_STR="-p ${APP_PORT_HTTP}:80"; fi
  if [[ -n "${APP_PORT_HTTPS}" ]]; then FW_APP_PORT_HTTPS_STR="-p ${APP_PORT_HTTPS}:443"; fi
  if [[ -n "${SUPERVISOR_PORT}" ]]; then FW_SUPERVISOR_PORT_STR="-p ${SUPERVISOR_PORT}:9001"; fi
  if [[ -n "${PROJECT_NETWORK}" ]]; then CONNECT_NETWORK_STR="--network ${PROJECT_NETWORK}"; fi

  # Force kill Container
  if [[ "$(docker ps --all --filter "name=^/${APP_CONTAINER_NAME}$" --format '{{.Names}}')" == "${APP_CONTAINER_NAME}" ]]; then
    display_info "DOCKER: Force delete Container(${APP_CONTAINER_NAME}):"
    exec_command "docker rm ${APP_CONTAINER_NAME} --force"
    if [[ "$?" != "0" ]]; then
      reset_git
      display_error "DOCKER: Container deletion failed!"
    fi
  fi

  # Docker run Container.
  display_info "DOCKER: Run Container(${APP_CONTAINER_NAME}):"
  exec_command "docker run -d -it --restart always --memory-swap -1 \
    --name ${APP_CONTAINER_NAME} \
    ${FW_APP_PORT_HTTP_STR:-} \
    ${FW_APP_PORT_HTTPS_STR:-} \
    ${FW_SUPERVISOR_PORT_STR:-} \
    --env-file ${ENV_FILE} \
    --add-host host.docker.internal:host-gateway \
    ${PWD_MOUNTED_STORAGE_STR:-} \
    ${PWD_MOUNTED_SESSION_STR:-} \
    ${PWD_MOUNTED_CACHE_STR:-} \
    ${PWD_MOUNTED_UPLOAD_STR:-} \
    ${PWD_MOUNTED_APP_LOG_STR:-} \
    ${PWD_MOUNTED_PHP_LOG_STR:-} \
    ${PWD_MOUNTED_NGINX_LOG_STR:-} \
    ${PWD_MOUNTED_SUPER_LOG_STR:-} \
    ${CONNECT_NETWORK_STR:-} \
    ${APP_IMAGE_NAME}"

  if [[ "$?" != "0" ]]; then
    reset_git
    display_error "DOCKER: Running Container(${APP_CONTAINER_NAME}) failed!"
  fi
fi
## END: DEPLOY CONTAINER ###################################

## BEGIN: DOCKER RMI AND PRUNE #############################
if [[ ${DOCKER_RMI_FLAG} -eq 1 ]]; then
  display_info "DOCKER: Remove all docker image without name:"
  exec_command "docker images -a | grep none | awk '{ print \$3; }' | xargs docker rmi --force 2>/dev/null"
fi

if [[ ${DOCKER_PRUNE_FLAG} -eq 1 ]]; then
  display_info "DOCKER: Remove build cache:"
  exec_command "docker builder prune --all --force --keep-storage=512m"
fi
## END: DOCKER RMI AND PRUNE ###############################

display_info "__END__"
## END #########################################################################
