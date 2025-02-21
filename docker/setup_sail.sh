#!/usr/bin/env bash

# Base dirname.
PWD_HERE=$(dirname -- "$0")
PWD_ROOT=$(realpath "${PWD_HERE}/..")

# Docker directory.
PWD_DOCKER="${PWD_ROOT}/docker"

chmod +x "${PWD_DOCKER}/sail" "${PWD_DOCKER}/sails/bin/sail"

echo "Setup Sail successfully."
