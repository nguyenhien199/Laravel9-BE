#!/usr/bin/env sh

# Base dirname
PWD_HERE=$(dirname -- "$0")
PWD_ROOT=$(realpath "${PWD_HERE}/..")

# For Laravel
mkdir -p ${PWD_ROOT}/bootstrap/cache ${PWD_ROOT}/storage 
chmod -R 777 ${PWD_ROOT}/bootstrap/cache ${PWD_ROOT}/storage

echo "Done !!!"
