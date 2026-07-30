# CLAUDE.md — ProDC VMS Laravel

> **Repo:** https://github.com/XsyCodee/vms-laravel
> **Primary project:** https://github.com/XsyCodee/vms-sdc (Next.js)
> **Laravel = backup**

## Aturan

1. Jangan push ke vms-sdc — itu repo Next.js
2. Push ke vms-laravel: `git push origin main`
3. File ≤ 500 lines — split if bigger
4. Update README.md tiap perubahan besar

## Deploy

```bash
# Github
git add -A && git commit -m "..." && git push origin main

# VPS
ssh root@103.177.60.237
cd /www/wwwroot/sdc.netvora.my.id
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
```
