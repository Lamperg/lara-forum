#!/usr/bin/env bash

#=============================================================================
# Variables
#=============================================================================
cd ../../
DOCKER_ROOT_DIR=`pwd`
DOCKER_SCRIPTS_DIR="${DOCKER_ROOT_DIR}/docker/scripts"

COLOR_RED="\e[31m"
COLOR_BLUE="\e[34m"
COLOR_DEFAULT="\033[0m"
#=============================================================================
# OS checking functions
#=============================================================================
is_linux() {
    if uname -a | grep -i "linux" > /dev/null;
    then
        debug "Linux system detected"
        true
    else
        false
    fi
}
is_mac() {
    if uname -a | grep -i "darwin" > /dev/null;
    then
        debug "OSX system detected"
        true
    else
        false
    fi
}
#=============================================================================
# Print functions
#=============================================================================
error() {
    echo -e "${COLOR_RED}$1${COLOR_DEFAULT}"
}
debug () {
    echo -e "${COLOR_BLUE}$1${COLOR_DEFAULT}"
}