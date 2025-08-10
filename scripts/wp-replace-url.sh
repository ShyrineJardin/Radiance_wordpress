#!/bin/bash

. ./scripts/init.sh

function usage() {
  printf "Usage: $0 <old_url> <new_url> <env>

Options:
  old_url      Old URL
  new_url      New URL (default: WP_HOME)\n"
  exit 1
}

function wp_replace_url() {
  local old_url="$1"
  local new_url="${2:-$WP_HOME}"

  if [ -z "$old_url" ]; then
    echo "ERROR: old_url is not set"
    usage
  fi

  echo -e "Replacing URL: ${BYellow}${old_url}${NColor} -> ${BGreen}${new_url}${NColor}"
  wp option update HOME "${new_url}" --allow-root
  wp option update SITEURL "${new_url}" --allow-root
  wp search-replace "${old_url}" "${new_url}" --all-tables --report-changed-only --allow-root --recurse-objects --skip-columns=guid
  wp search-replace "/wp-content/" "/app/" --all-tables --report-changed-only --allow-root --recurse-objects --skip-columns=guid
  wp rewrite flush --allow-root
}

wp_replace_url "$@"
