#!/usr/bin/env bash

source ./_config.sh
cd ${DOCKER_ROOT_DIR}

if is_linux; then
    # Available only in linux systems
    echo '==========================================================================================================='
    debug "The container IP is:"
    docker inspect -f '{{.Name}} - {{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' $(docker ps -aq) | grep -i "webserver"
    echo '==========================================================================================================='
fi
