---
description: Laravel Production Deployment Workflow
---
Follow these steps to deploy your application to a production server (Apache/Nginx on Linux or similar).

### 1. Core Deployment Commands
Run these commands in the root of your project directory on the server:

```bash
# 1. Install/Update PHP dependencies
composer install --no-dev --optimize-autoloader

# 2. Run database migrations (IMPORTANT)
php artisan migrate --force

# 3. Clear and cache configurations for speed
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Link the storage folder (if not linked)
php artisan storage:link
```

### 2. Environment Configuration
Ensure your `.env` file on the server has these settings:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_TIMEZONE=Asia/Dhaka

# Database Credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 3. Folder Permissions (Linux Servers)
If you are deploying to a Linux server, run these to fix permissions:
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 4. Cleanup After Updates
Whenever you push new code changes, always run:
```bash
php artisan optimize
```
