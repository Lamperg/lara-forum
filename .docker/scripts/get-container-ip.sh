#!/usr/bin/env bash
cd ../../
docker inspect -f '{{.Name}} - {{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' $(docker ps -aq) | grep -i "webserver"
