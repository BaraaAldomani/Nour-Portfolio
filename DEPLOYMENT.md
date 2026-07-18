# Deployment

GitHub Actions builds and tests on every push to `main`, then rsyncs over SSH to
Hostinger and runs the post-deploy commands. Production runs **MySQL 8** and
**PHP 8.3**.

---

## One-time setup

### 1. Point the document root at `public/`

Hostinger's default document root is the domain folder itself. It must point at
the application's `public/` directory instead, or the entire source tree is
served over the web.

### 2. Confirm the PHP binary

Shared hosting defaults to PHP 8.2. Find the 8.3 binary:

```bash
ls /usr/bin/php8.3 || ls /opt/alt/php83/usr/bin/php
```

If it is not at `/usr/bin/php8.3`, set `PHP_BIN` in the workflow's remote step.
This matters: `composer.json` pins `config.platform.php` to 8.3, and the app will
fatal on an older runtime.

### 3. Create the production environment file

Build `.env.production` locally — **never commit it unencrypted**:

```dotenv
APP_NAME="Nour Aldeen Aldomani"
APP_ENV=production
APP_KEY=            # php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://your-domain.com

APP_LOCALE=ar
APP_FALLBACK_LOCALE=en

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public

LOG_CHANNEL=stack
LOG_LEVEL=warning
```

Encrypt it and commit only the encrypted file:

```bash
php artisan env:encrypt --env=production
# prints a key — store it as the LARAVEL_ENV_ENCRYPTION_KEY secret

git add .env.production.encrypted
```

`.gitignore` already allows `.env.*.encrypted` through and blocks everything
else, so configuration ships through git and nobody edits `.env` over SSH.

### 4. Repository secrets

| Secret | Value |
| --- | --- |
| `SSH_HOST` | Hostinger server hostname |
| `SSH_PORT` | SSH port (usually `65002`) |
| `SSH_USER` | Hostinger SSH username |
| `SSH_PRIVATE_KEY` | Private half of a key added to the server's `authorized_keys` |
| `DEPLOY_PATH` | `/home/<user>/domains/<domain>/public_html` |
| `LARAVEL_ENV_ENCRYPTION_KEY` | Key printed by `env:encrypt` |

### 5. First deploy only — by hand

After the first pipeline run, seed the content and create the admin **once**:

```bash
cd /home/<user>/domains/<domain>/public_html

/usr/bin/php8.3 artisan db:seed --force
/usr/bin/php8.3 artisan app:create-admin
```

These two commands are deliberately **absent from the pipeline**. Re-seeding a
live site would overwrite everything edited in the dashboard.

---

## What the pipeline does, and why the order matters

Each of these steps exists because the obvious ordering breaks.

1. **`env:decrypt --force`** — writes `.env` from the committed encrypted file.

2. **`rm -f bootstrap/cache/*.php`** — with plain `rm`, *before* any artisan
   call. A stale cached config makes service providers boot against outdated
   configuration and crash; once that happens `artisan config:clear` cannot run
   either, because it needs the framework to boot. Removing the files directly is
   the only thing that reliably recovers.

3. **`config:clear`, `route:clear`, `view:clear`** — file-based clears, safe to
   run before the database is in a known state.

4. **`migrate --force`**.

5. **`cache:clear`** — and only now. The cache store is database-backed, so on a
   fresh database this fails with "table not found" if it runs before the
   migration that creates the cache table.

6. **`filament:assets`** and **`storage:link`** — Filament's compiled assets are
   gitignored and must be republished on the server.

7. **`config:cache`, `route:cache`, `view:cache`** — production warm-up.

The nginx config carries one related fix worth remembering:
`location ^~ /livewire/ { try_files $uri /index.php?$query_string; }`. Filament
serves some assets through PHP, and without this the admin panel loads unstyled
and inert.

---

## Verifying a deploy

```bash
curl -sI https://your-domain.com/            # 301 -> /ar
curl -s  https://your-domain.com/sitemap.xml | head
```

Then check in a browser that `/ar` renders RTL, `/en` renders LTR, and that
signing in at `/admin` and changing a theme colour is reflected on the public
site immediately.

---

## Rolling back

The deploy is a file sync, so rolling back is a redeploy of the previous commit:

```bash
git revert <bad-commit>
git push
```

Migrations are **not** rolled back automatically. If a bad migration shipped,
decide deliberately whether to `migrate:rollback` — on a live site with real
dashboard edits, restoring from a database backup is usually the safer path.
