#!/usr/bin/env bash
# db-export.sh: Export and compress wp database.

. ./scripts/bash_colors
. .env

# Load local composer's bin
PATH="./vendor/bin:$PATH"
DATA_DIR="${DATA_DIR:-".data"}"
DUMP_PATH="${DUMP_PATH:-"${DATA_DIR}/dump"}"
DUMP_VERSION="$(date --utc +"%Y%m%dT%H%M%SZ")"
