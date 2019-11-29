#!/usr/bin/env bash

source ./_config.sh
cd ${DOCKER_SCRIPTS_DIR}

# Build container (you can use '--no-cache' and '--force-recreate' params)
#=============================================================================
bash ./start.sh --build $@

# Install dependencies
#=============================================================================
bash ./composer.sh install
bash ./npm.sh install
bash ./artisan.sh migrate --seed

# Show current container IP
#=============================================================================
bash ./_get-container-ip.sh
