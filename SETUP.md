# Horizon School — Local setup

Run these **one at a time** in PowerShell from the project folder:

```powershell
cd "f:\Rohit Development\horizon school"
```

### 1. Database tables (CMS + Phase A)

```powershell
php artisan migrate
```

After Phase A updates, run migrate again if you already migrated before.

### 2. Default site settings + demo content (images, news, slides)

```powershell
php artisan db:seed
```

Or reload demo only:

```powershell
php artisan db:seed --class=DemoSeeder
```

### 3. Public uploads (photos)

```powershell
php artisan storage:link
```

### 4. Frontend assets (CSS/JS)

```powershell
npm install
npm run build
```

### 5. Run site

```powershell
php artisan serve
```

- **Website:** http://127.0.0.1:8000  
- **Admin CMS:** http://127.0.0.1:8000/admin  

## Phase C — migrate + seed

```powershell
php artisan migrate
php artisan db:seed --class=PhaseCSeeder
```

Adds: **SEO** fields, **Mandatory Disclosure** PDFs, **sitemap.xml**.

Public URLs:
- `/mandatory-disclosure`
- `/sitemap.xml`

## Phase B — migrate once

```powershell
php artisan migrate
```

Adds **admission enquiries** table and **user roles** (admin / editor).

## Roles

| Role | Access |
|------|--------|
| **admin** | Everything + Site Settings + Users |
| **editor** | Content + view admission enquiries (cannot delete or change settings) |

Create users in admin → **Users** (admin only). Your existing login stays **admin**.

## Phase D — real school content

```powershell
php artisan db:seed --class=PhaseDSeeder
```

Removes joke YouTube demos, swaps random internet photos for local placeholders.

**Full step-by-step guide:** see **[CONTENT.md](CONTENT.md)** in the project folder.

Admin dashboard shows a **Content checklist** widget.

## Admin workflow

1. **Site Settings** — school name, phone, WhatsApp, logo  
2. **Home Slides** — hero images  
3. **News & Posts** — announcements / achievements / events (toggle **Published**, set **Published at**)  
4. **Gallery**, **Facilities**, **Videos (YouTube URL)**  
5. **Pages** — About, Admissions, etc. → URL: `/page/your-slug`

See **CONTENT.md** for the complete replacement checklist.

## Speed tips

- Upload compressed images (under 500 KB when possible)  
- YouTube: paste URL only; site shows thumbnail, plays embedded on your page when clicked  
- On VPS: `php artisan config:cache` and `php artisan route:cache`
