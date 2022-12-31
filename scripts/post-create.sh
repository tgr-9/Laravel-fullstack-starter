#!/bin/env bash

chown -R 1000:1000 /var/www/html

mkdir -p /var/log/creasi/

corepack enable
corepack prepare pnpm@latest --activate

pnpm install
pnpm build
