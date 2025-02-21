#!/usr/bin/env bash

## Show help: bash /path/build.sh -h

# Base dirname.
PWD_HERE=$(dirname -- "$0")
PWD_ROOT=$(realpath "${PWD_HERE}/../..")

## DEFAULT DATA DEFINITION #################################
# Base-Image
BASE_SHORT_PATH="/docker/base"
BASE_DOCKER_PWD="${PWD_ROOT}${BASE_SHORT_PATH}"
BASE_ENV_FILE="${BASE_DOCKER_PWD}/.env"
BASE_COMPOSE_FILE="${BASE_DOCKER_PWD}/docker-compose.yml"
BASE_ARGS=()

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
  echo "Unknown arguments will give an error."
  echo
  echo "${YELLOW}Options:${NC}"
  echo "  ${GREEN}-h, --help${NC}             Show help."
  echo
  echo "      ${GREEN}--no-cache${NC}         Do not use Caching when building Images."
  echo "      ${GREEN}--memory=BYTES${NC}     Set Memory limit for Base-Image building process (eg: 512M or 1G) (default: 512M). Not supported by BuildKit."
  echo "      ${GREEN}--progress=STRING${NC}  Set Type of progress output (auto, tty, plain, quiet) (default: auto)."
  echo "      ${GREEN}--pull${NC}             Always attempt to pull a newer version of the Base-Image (is: php:\${JV_PHP_VERSION}-fpm)."
  echo
  exit 1
}

## Argument Validation function.
# Usage: validation "$@";
function validation() {
  while [[ $# -gt 0 ]]; do
    case "$1" in
      -h|help|-help|--help)
        display_help
        shift ;;
      --no-cache|--no-cache=true)
        BASE_ARGS+=("--no-cache")
        shift ;;
      --memory=*)
        local memory="$(echo $1 | sed -e 's/^[^=]*=//g')"
        if [[ -n "${memory}" ]]; then
          BASE_ARGS+=("--memory=${memory}")
        else
          BASE_ARGS+=("--memory=512M")
        fi
        shift ;;
      --progress=*)
        local progress="$(echo $1 | sed -e 's/^[^=]*=//g')"
        if [[ -n "${progress}" ]]; then
          BASE_ARGS+=("--progress=${progress}")
        else
          BASE_ARGS+=("--progress=auto")
        fi
        shift ;;
      --pull|--pull=true)
        BASE_ARGS+=("--pull")
        shift ;;
      *)
        display_error "Argument '$1' is not defined!"
        shift ;;
    esac
  done

  # Check Base ENV file exists.
  if [[ ! -f "${BASE_ENV_FILE}" ]]; then
    display_error "BASE ENV: '${BASE_ENV_FILE//${PWD_ROOT}/}' file does not exist!"
  fi
  # Check Base Compose file exists.
  if [[ ! -f "${BASE_COMPOSE_FILE}" ]]; then
    display_error "BASE COMPOSE: '${BASE_COMPOSE_FILE//${PWD_ROOT}/}' file does not exist!"
  fi
}

## BEGIN #######################################################################
initial
validation "$@"

## BEGIN: BUILD BASE-IMAGE #################################
# Get JV BASE from "/docker/base/.env".
ENV_BASE_IMAGE_NAME="$(grep '^JV_BASE_IMAGE_NAME' ${BASE_ENV_FILE} | sed -e 's/^[^=]*=//g' | xargs)"

# Check Base-Image repository.
BASE_IMAGE_REPO="$(echo ${ENV_BASE_IMAGE_NAME} | cut -d':' -f 1)"
if [[ -z "${BASE_IMAGE_REPO}" ]]; then
  display_error "BASE: Base-Image undefined! (Let's define the variable 'JV_BASE_IMAGE_NAME' in the file '${BASE_ENV_FILE//${PWD_ROOT}/}')!"
fi

# Check Base-Image tag.
BASE_IMAGE_TAG="$(echo ${ENV_BASE_IMAGE_NAME} | cut -d':' -f 2)"
if [[ -z "${BASE_IMAGE_TAG}" ]]; then
  BASE_IMAGE_TAG='latest'
fi

# Set Base-Image name.
BASE_IMAGE_NAME="${BASE_IMAGE_REPO}:${BASE_IMAGE_TAG}"

display_info "DOCKER: Start building for Base-Image(${BASE_IMAGE_NAME}):"
BASE_ARGS_STR="${BASE_ARGS[@]}"

# Docker Compose build Base-Image.
display_command "docker compose --file=${BASE_COMPOSE_FILE//${PWD_ROOT}/} --env-file=${BASE_ENV_FILE//${PWD_ROOT}/} build --build-arg BASE_IMAGE_NAME=${BASE_IMAGE_NAME} ${BASE_ARGS_STR//${PWD_ROOT}/}"
docker compose --file=${BASE_COMPOSE_FILE} --env-file=${BASE_ENV_FILE} build --build-arg BASE_IMAGE_NAME=${BASE_IMAGE_NAME} ${BASE_ARGS_STR}

if [[ $? -eq 0 ]]; then
  display_info "DOCKER: Base-Image(${BASE_IMAGE_NAME}) build completed."
else
  display_error "DOCKER: Base-Image(${BASE_IMAGE_NAME}) build failed!"
fi
## END: BUILD BASE-IMAGE ###################################

## END #########################################################################
