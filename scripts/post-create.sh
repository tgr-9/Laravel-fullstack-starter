#!/bin/env bash

chown -R 1000:1000 /var/www/html

corepack enable
corepack prepare pnpm@latest --activate

pnpm install
pnpm build
