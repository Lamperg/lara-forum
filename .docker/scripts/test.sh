#!/usr/bin/env bash
cd ../../
docker-compose exec --user www app php vendor/bin/phpunit $@
