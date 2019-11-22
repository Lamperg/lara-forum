#!/usr/bin/env bash
bash ./start.sh --build

bash ./composer.sh install
bash ./npm.sh install

bash ./artisan.sh migrate --seed

bash ./get-container-ip.sh

#docker-compose build --no-cache
#docker-compose up -d --force-recreate
