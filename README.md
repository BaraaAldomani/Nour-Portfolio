# Nour Aldeen Aldomani — Executive Chef

A bilingual (Arabic / English) portfolio site for a Riyadh-based executive chef.
Arabic is the default language and RTL is a first-class layout, not a mirror of
the English one.

- **Stack** — Laravel 13 · PHP 8.3 · Tailwind v4 · vanilla JS · Filament v4 admin at `/admin`
- **Local** — Docker (nginx `8082`, Postgres `5434`, Vite `5175`)
- **Production** — Hostinger + MySQL 8, deployed by GitHub Actions

---

## Running it locally

```bash
cp .env.example .env

docker compose up -d db app nginx
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan app:create-admin

# Front-end: either a one-off build...
docker compose run --rm node sh -c "npm install && npm run build"
# ...or the dev server with hot reload
docker compose up node
```

The site is at <http://localhost:8082> and the dashboard at
<http://localhost:8082/admin>.

### Two things that will bite you otherwise

**`vendor/` and `node_modules/` live in named volumes, not on the bind mount.**
Walking the ~13,000 files in `vendor/` across a Windows bind mount takes about
45 seconds; from the VM's own filesystem it is milliseconds. Since OPcache is
deliberately off in development, every single request would otherwise pay that
cost. The consequence is that the host cannot see `vendor/` — if your editor
needs it for autocomplete, run `composer install` locally as well. Both
directories are gitignored either way.

**OPcache is off in development and on in production.** Windows bind mounts do
not report file modification times reliably, so a cached opcode never
invalidates and your edits appear to do nothing.

---

## How the content works

There are two kinds of content and they are stored differently.

**Structural, repeating content** — dishes, services, experience, education,
skills, metrics, method steps — lives in its own database table, one per type,
with `{field}_ar` / `{field}_en` column pairs and a `sort_order`. These are
managed under **Content** in the dashboard and are reorderable by dragging.

**Singleton copy** — headings, hero text, contact details, SEO defaults — lives
in a `settings` table keyed by `(group, key)`. Every default is defined once in
[`app/Support/SettingsDefaults.php`](app/Support/SettingsDefaults.php), which is
read by *both* the seeder and the dashboard pages. That is the single source of
truth: add a key there and it appears in the dashboard automatically, with no
second copy in a lang file waiting to drift.

Lang files hold chrome only — navigation labels, form labels, aria strings.

### Reading it

[`App\Services\SiteContent`](app/Services/SiteContent.php) is the only read
layer. It is a singleton shared into every view as `$site`, so Blade never
touches Eloquent directly.

Two different caching strategies, on purpose:

- The **settings map** is a plain array, so it is cached persistently.
- **Content collections** are memoised per request only. Eloquent collections do
  not survive a round-trip through the database cache store — they come back as
  `__PHP_Incomplete_Class` and every property access fatals. Re-querying once per
  request is cheap; debugging that is not.

A `ContentObserver` on every content model and on `Setting` flushes the cache on
save and delete, which is why a dashboard edit is live on the very next request.

---

## The design system

`resources/css/tokens.css` defines **exactly three** editable brand colours:

| Token | Default | Role |
| --- | --- | --- |
| `--brand-primary` | `#C8A24C` | Gold — links, buttons, the plate ring |
| `--brand-secondary` | `#0F0E0C` | Near-black — page background and ink |
| `--brand-accent` | `#E8DCC8` | Cream — body text on dark, light sections |

Every other colour on the site — full ramps, surfaces, text, borders, glass
tints, glows — is derived from those three with `color-mix(in oklab, …)`. The
dashboard injects an inline `<style>:root{…}</style>` **after** `@vite`, so
changing a colour there re-themes the entire site on the next request with no
rebuild.

`app.css` maps the tokens to Tailwind utilities with `@theme inline` and wipes
the stock palette (`--color-*: initial`), so `bg-red-500` and friends do not
exist. **Blade contains no raw hex values** — only semantic utilities like
`bg-surface`, `text-ink`, `text-muted`, `border-line`, `bg-primary`.

### Light and dark registers

The site is dark by default. Adding `surface-light` to a section re-points the
same semantic tokens at the cream palette; nothing inside the section needs to
know it changed.

### Contrast

Every text and control pair was measured in-browser, not eyeballed. All pass
WCAG AA:

| Pair | Dark | Light | Minimum |
| --- | --- | --- | --- |
| `ink` on `surface` | 14.24 | 16.47 | 4.5 |
| `muted` on `surface` | 5.28 | 8.56 | 4.5 |
| `faint` on `surface` | 4.54 | 4.90 | 4.5 |
| `primary` on `surface` | 8.02 | 6.68 | 4.5 |
| `on-primary` on `primary` | 8.02 | 6.57 | 4.5 |
| `control-line` on `surface` | 3.25 | 3.83 | 3.0 |

Note the separate `--color-control-line`. The decorative hairlines are far too
faint to serve as the visible boundary of an input or a button, which WCAG 1.4.11
holds to 3:1. Interactive borders use `control-line`; `line` is for dividers
only.

On a light surface the raw gold is only ~2.3:1 and **must never carry text** —
`--color-primary` is darkened in the light register for exactly this reason.

### RTL

Use CSS logical properties (`inset-inline-start`, `ms-*`, `text-start`) — never
`left` / `right`. The one deliberate exception is `.center-abs` / `.center-abs-top`
in `app.css`, and the comment there explains why: centring is symmetric, and the
obvious logical alternative (`inset: 0` plus `margin: auto`) silently mirrors
between languages when the element is larger than its container.

### Motion

One small vanilla JS file: scroll reveals with stagger, count-up statistics, the
mobile nav, and the rotating plate rings. Hidden states are scoped to `html.js`,
so content is fully visible without JavaScript and to crawlers.
`prefers-reduced-motion: reduce` disables all decorative animation in both CSS
and JS — content appears instantly rather than merely animating faster.

---

## Testing

```bash
docker compose exec app php artisan test
docker compose exec app php artisan site:verify-inventory
```

`site:verify-inventory` checks the seeded row counts against the content
inventory this site was specified with. It is the quickest way to catch a seeder
that half-ran.

---

## Deploying

See [DEPLOYMENT.md](DEPLOYMENT.md).
