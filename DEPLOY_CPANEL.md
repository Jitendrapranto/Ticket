# cPanel Deployment Guide — TicketKinun

## 1. Upload Files

Upload the **entire project** into `public_html/` on your cPanel file manager or via FTP.
Your final structure on the server should look like:

```
public_html/
├── .htaccess          ← root htaccess (routes traffic to public/)
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── .htaccess      ← Laravel routing + HTTPS redirect
│   ├── .user.ini      ← PHP settings
│   └── index.php
├── resources/
├── routes/
├── storage/
├── vendor/
└── ...
```

> **Do NOT upload:** `node_modules/`, `.git/`, `diff.txt`, `test.md`

---

## 2. Set Up the `.env` File

Copy `.envproduction` → `.env` on the server, then update:

```env
APP_KEY=base64:6ixtEt4Tp/t/Ir1wH6vfuGE6FuQI7CvslDnEeIE/gRs=
APP_URL=https://ticketkinun.com

DB_HOST=127.0.0.1
DB_DATABASE=ticketki_Ticket
DB_USERNAME=ticketki_Ticket
DB_PASSWORD=ticketki_Ticket        ← set your real password
```

---

## 3. Create the Database

In cPanel → **MySQL Databases**:
1. Create database: `ticketki_Ticket`
2. Create user: `ticketki_Ticket` with a strong password
3. Add user to database with **All Privileges**
4. Update the `DB_PASSWORD` in `.env`

---

## 4. Run Artisan Commands via cPanel Terminal (or SSH)

```bash
cd public_html

# Install dependencies (if not uploading vendor/)
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link

# Cache config/routes for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 5. Set Directory Permissions

Via cPanel File Manager or SSH:

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

## 6. Verify

- Visit `https://ticketkinun.com` — should load the app
- Visit `https://ticketkinun.com/storage` — should resolve (storage link works)
- Check `storage/logs/laravel.log` if anything fails

---

## Troubleshooting

| Issue | Fix |
|---|---|
| 500 error | Check `storage/logs/laravel.log`; verify `.env` exists |
| Blank page | Set `APP_DEBUG=true` temporarily, reload, then disable |
| Assets not loading | Run `php artisan storage:link` |
| DB error | Verify DB credentials in `.env` and cPanel MySQL |
| HTTPS redirect loop | Disable the HTTPS rule in `public/.htaccess` if SSL is not configured yet |
