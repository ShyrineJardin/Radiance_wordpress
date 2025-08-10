#!/usr/bin/env bash
# db-import.sh: Import wp database.

. ./scripts/init.sh

function usage() {
  printf "Usage: $0 <destination> <input>

Options:
  input        Compressed input file (.gz)\n"
  exit 1
}

function db_import() {
  local source_file="$1"
  local sql_file="${source_file%.gz}"

  if [[ ! -f "${source_file}" ]]; then
    echo -e "${BRed}ERROR${NColor}: file not found ${BYellow}${source_file}${NColor}"
    usage
  fi

  gzip -dkf ${source_file}
  sed -i '/*!999999\- enable the sandbox mode */' "${sql_file}" 2>/dev/null
  wp db import --allow-root "${sql_file}" && rm -rf "${sql_file}"
}

db_import "$@"
