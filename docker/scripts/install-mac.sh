#!/usr/bin/env bash

cd ../../
docker-sync start
docker-compose -f docker-compose.yml -f docker-compose-mac.yml up -d --build

bash ./composer.sh install
bash ./npm.sh install

bash ./artisan.sh migrate --seed
