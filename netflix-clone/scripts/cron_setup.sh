#!/bin/bash

# Setup the cron job for the backup script to run every minute (for testing)
echo "0 3 * * * root /bin/bash /var/www/html/scripts/backup_script.sh" > /etc/cron.d/backup-cron

# Apply the cron job
chmod 0644 /etc/cron.d/backup-cron

# Restart cron to apply the new job
service cron restart
