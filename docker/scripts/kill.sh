#!/usr/bin/env bash
cd ../..

docker-sync stop
docker-sync clean

cd docker/scripts/
docker-compose stop
docker-compose down -v
