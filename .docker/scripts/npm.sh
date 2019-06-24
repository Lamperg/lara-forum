#!/usr/bin/env bash
cd ../..
docker-compose exec --user www-data app npm $@
