#!/bin/bash

PHP_PATH=$(which php)
PROJECT_DIR=$(cd "$(dirname "$0")"; pwd)
CRON_FILE="$PROJECT_DIR/cronjob.txt"
CRON_CMD="$PHP_PATH $PROJECT_DIR/cron.php"

# Remove old cron entry if any
crontab -l 2>/dev/null | grep -v "$CRON_CMD" > "$CRON_FILE"

# Add new cron job (runs every day at 9:00 AM)
echo "0 9 * * * $CRON_CMD" >> "$CRON_FILE"

# Install new cron file
crontab "$CRON_FILE"
rm "$CRON_FILE"

echo "Cron job set to run daily at 9:00 AM."
