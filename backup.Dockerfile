FROM debian:bullseye-slim

# Install required tools and libraries
RUN apt-get update && apt-get install -y \
    cron \
    default-mysql-client \
    gzip \
    procps && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Set work directory to match the Laravel container
WORKDIR /var/www/html

# Copy the backup script
COPY netflix-clone/scripts/backup_script.sh /var/www/html/scripts/backup_script.sh
RUN chmod +x /var/www/html/scripts/backup_script.sh

# Copy the cron setup script
COPY netflix-clone/scripts/cron_setup.sh /var/www/html/scripts/cron_setup.sh
RUN chmod +x /var/www/html/scripts/cron_setup.sh

# Add cron job setup
RUN /var/www/html/scripts/cron_setup.sh

# Run cron in the foreground so the container stays alive
CMD cron -f
