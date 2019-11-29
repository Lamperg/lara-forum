#!/usr/bin/env bash

source ./_config.sh
cd ${DOCKER_ROOT_DIR}

# Detect OS
#=============================================================================
if is_mac; then
    # Start docker-service for OSX system
    #=========================================================================
    docker-sync start
    docker-compose -f docker-compose.yml -f docker-compose-mac.yml up -d $@
elif is_linux; then
    # Start docker-service for Linux system
    #=========================================================================
    docker-compose up -d $@
else
    # Unsupported OS
    #=========================================================================
    error "Your os is not supported"
fi
