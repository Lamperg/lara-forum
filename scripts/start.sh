#!/usr/bin/env bash
cd ..
docker-sync start && \
docker-compose up -d $@
