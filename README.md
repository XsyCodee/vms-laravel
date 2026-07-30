# ProDC VMS — Laravel + Filament

> **Backup project** — primary is Next.js at [vms-sdc](https://github.com/XsyCodee/vms-sdc)
> **Production:** https://sdc.netvora.my.id/admin
> **Dev:** http://sdc.netvora.my.id.test/admin

---

## Tech Stack

| Layer | Tech |
|-------|------|
| Framework | Laravel 11 |
| Admin Panel | Filament 3 |
| Database | MySQL (prod) / SQLite (dev) |
| PHP | 8.4+ |

## Login

| Email | Password |
|-------|----------|
| `admin@vms.local` | `Tahun2026_!@#` |

## Local Dev

```bash
cd C:\laragon\www\sdc.netvora.my.id
php artisan serve
# or use Laragon: http://sdc.netvora.my.id.test/admin
```

## Production Deploy

```bash
cd /www/wwwroot/sdc.netvora.my.id
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan event:cache
```

## Database Import (Local)

```bash
php artisan migrate:fresh --seed --seeder=ImportDataSeeder --force
```

This imports from `C:\laragon\www\sdc\data\daftar-perangkat.xlsx` — 150+ customers, 170+ racks, 3200+ equipment records.

## Sidebar (7 groups, matches Next.js)

- 🏠 Home: Dashboard, Inbox, Tickets
- 🏗️ Infrastructure: Topology, Data Rack, Data Colo Client, Colocation View
- 🔗 Interkoneksi: Data Interkoneksi, Request Interkoneksi
- 🛡️ Security: Visitor Permits, Security Centers
- 👥 Client Management: Client Devices, Client Accounts
- 🖥️ Manage Device: Data Perangkat, Data FST, Master Devices
- ⚙️ Settings: Customers, Users, Settings

## Related Repos

- **Next.js (primary):** https://github.com/XsyCodee/vms-sdc
- **Laravel (backup):** https://github.com/XsyCodee/vms-laravel
