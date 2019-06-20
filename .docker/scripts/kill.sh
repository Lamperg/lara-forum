#!/usr/bin/env bash
cd ../..
docker-compose stop
docker-sync stop
docker-compose down -v
docker-sync clean
