#!/bin/bash

ENV_FILE="/var/www/html/.env"

if [ -f "$ENV_FILE" ]; then
    export $(grep -v '^#' "$ENV_FILE" | xargs)
else
    echo "Error: .env file not found at $ENV_FILE"
    exit 1
fi

BACKUP_DIR="/backups"
DATE=$(date +"%Y-%m-%d_%H-%M-%S")
DB_NAME="${DB_DATABASE}"
DB_USER="${DB_USERNAME}"
DB_PASSWORD="${DB_PASSWORD}"
DB_HOST="mysql_db"

mkdir -p "$BACKUP_DIR"

DUMP_FILE="$BACKUP_DIR/$DB_NAME-$DATE.sql"
echo "Dumping database to: $DUMP_FILE"
export MYSQL_PWD="$DB_PASSWORD"
mysqldump -h "$DB_HOST" -u "$DB_USER" "$DB_NAME" > "$DUMP_FILE"

if [ $? -ne 0 ]; then
    echo "Error: Database dump failed. Removing incomplete dump file."
    rm -f "$DUMP_FILE"
    exit 1
fi

echo "Compressing backup to: $DUMP_FILE.gz"
gzip "$DUMP_FILE"

if [ $? -ne 0 ]; then
    echo "Error: Compression failed. Backup is incomplete."
    exit 1
fi

echo "Backup completed: $DUMP_FILE.gz"
