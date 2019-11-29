#!/usr/bin/env bash

source ./_config.sh
cd ${DOCKER_ROOT_DIR}

# Detect OS
#=============================================================================
if is_mac; then
    # OSX
    #=========================================================================
    docker-sync stop
    docker-sync clean
    docker-compose stop
    docker-compose down -v
elif is_linux; then
    # Linux
    #=========================================================================
    docker-compose stop
    docker-compose down -v
else
    # Unsupported OS
    #=========================================================================
    error "Your os is not supported"
fi
