#!/usr/bin/env sh
set -eu

# Replace ENV variables in config file
envsubst '${APP_NAME}' < /home/root/nginx/app.conf > /etc/nginx/conf.d/app.conf

exec "$@"
