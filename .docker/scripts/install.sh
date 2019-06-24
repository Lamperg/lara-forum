#!/usr/bin/env bash
bash ./start.sh --build

bash ./artisan.sh migrate --seed
