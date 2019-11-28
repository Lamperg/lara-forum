#!/usr/bin/env bash
cd ../../
#docker-compose exec --user www-data app composer $@
docker-compose exec --user www app composer $@
