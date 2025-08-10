#!/usr/bin/env bash
# db-export.sh: Export and compress wp database.

. ./scripts/init.sh

function db_export() {
  # Create directory if does not exist
  mkdir -p $DUMP_PATH

  echo -e "Exporting local database: ${BCyan}${DUMP_PATH}/${DB_NAME}_${DUMP_VERSION}.sql.gz${NColor}"
  wp db export --allow-root --add-drop-table --skip-plugins --skip-packages --single-transaction --quick --lock-tables=false - | grep -v '/\*!999999\\- enable the sandbox mode \*/' | gzip -9 - >"${DUMP_PATH}/${DB_NAME}_${DUMP_VERSION}.sql.gz"
}

db_export "$@"
