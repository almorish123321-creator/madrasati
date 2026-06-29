#!/bin/bash
# Start script for Madrasati Laravel project

export PATH="/home/z/php-local/usr/bin:$PATH"
export PHPRC="/home/z/php-local/etc/php/cli"
export LD_LIBRARY_PATH="/home/z/php-local/usr/lib/x86_64-linux-gnu:$LD_LIBRARY_PATH"

# Critical: unset DATABASE_URL to prevent override of SQLite config
unset DATABASE_URL

cd /home/z/my-project/madrasati

# Start PHP built-in server on port 8000, bound to all interfaces
php -S 0.0.0.0:8000 -t public 2>&1
