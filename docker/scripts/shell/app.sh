#!/usr/bin/env bash

source ../_config.sh
cd ${DOCKER_ROOT_DIR}

docker-compose exec --user www app bash $@
