# minerctl

> Minerctl web application/backend

## Requirements
### System
- PHP-7.2 (Recomended) or php7.x with gd compiled
- php-mcrypt, php-mbstring, php-zip, php-json, php-xml, php-gd

## Installation
The installation is quite straightforward. Follow the steps below and you'll be up and running in minutes.

``` bash
git clone https://github.com/IlyasDeckers/minerctl-backend.git minerctl-backend

# Set the appropriate permissions
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

# install dependencies
npm install && composer update

# Create a .env file
cp .env.example .env

# Get a database up and running (sqlite for example)
touch database/database.sqlite
php artisan migrate

# Generate keys
php artisan key:generate && php artisan passport:install
```
The final step is to set up a cron job
``` bash
crontab -e
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```
