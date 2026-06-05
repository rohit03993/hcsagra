# Replace demo content with your school data (Phase D)

Use the admin panel: **http://127.0.0.1:8000/admin** (login required).

Run this once if you already had old demo images / joke YouTube videos:

```powershell
cd "f:\Rohit Development\horizon school"
php artisan db:seed --class=PhaseDSeeder
```

Then refresh the homepage.

---

## Checklist (do in this order)

### 1. Site Settings (admin only)
| Field | What to enter |
|--------|----------------|
| School name, tagline, affiliation | Your real names |
| Who We Are | 2–4 sentences for the homepage |
| Mission / Vision | Your school text; pick **one** “Read more” page for both |
| Phone, email, address | Real contact details |
| WhatsApp URL | `https://wa.me/91XXXXXXXXXX` (country code, no +) |
| Logo | Upload PNG/SVG (square, ~200×200 px) |
| Favicon | Small icon (optional) |
| Facebook / Instagram / YouTube | **Full links** to your pages (leave empty if none) |
| Custom admission link | **Optional** — leave empty to use the built-in enquiry form |

**Save** → open homepage and check header + footer.

---

### 2. Home Slides (banner)
- Add **3–5 slides** with real campus photos (JPG/WebP, **under 2 MB** each).
- Title + subtitle on each slide.
- Button: link to admission enquiry.
- Drag **sort order** so the best photo is first.
- Toggle **Published** on.

---

### 3. News & Posts
For each item: **Announcements**, **Achievements**, **Events**
- Upload a small thumbnail (optional).
- Set **Published** + **Published at** date.
- Delete demo posts you do not need.

---

### 4. From the Desk
- Upload **Principal** and **Chairman** photos (portrait, square).
- Replace names, designations, and messages.

---

### 5. Facilities
- One card per facility (lab, library, sports, etc.).
- Upload a real photo for each.

---

### 6. Gallery
- Upload event photos (Annual Day, Sports Day, etc.).
- Use **Album** name to group (e.g. `Annual Day 2025`).

---

### 7. Videos (YouTube)
- **Create** new entries with your real URLs, e.g. `https://www.youtube.com/watch?v=YOUR_ID`
- Campus tour, Annual Day, etc.
- Do **not** use random demo links.
- Toggle **Published** when ready.

---

### 8. Parents' Speak (Testimonials)
- Real parent quotes (with permission).
- Author name + label (e.g. `Parent of Class VIII-A`).

---

### 9. Pages
Edit slugs used in the menu, e.g.:
- `vision-mission`, `admission-procedure`, `fee-structure`, `curriculum-overview`
- Add body text and optional hero image.

---

### 10. Mandatory Disclosure (Phase C)
- **Disclosure PDFs** resource: upload CBSE PDFs.
- Public page: `/mandatory-disclosure`

---

## Image tips (automatic in admin)
- Upload **any size** JPG/PNG in admin, then click **Edit** on the image.
- **Drag and zoom** in the editor to show the part you want (e.g. move crop to the **top** for faces in desk photos).
- Click **Save** in the editor, then **Save changes** on the form.
- Presets: banner **1200×675**, gallery **800×800**, facilities/news **800×500**, desk photos **400×400**, logo **400×400**.
- Run `php artisan storage:link` once so uploads work.

---

## Verify on the site
| URL | Check |
|-----|--------|
| `/` | Banner, about, news, mission, desk, gallery |
| `/news` | Post lists |
| `/gallery` | Photos |
| `/videos` | YouTube thumbnails play embedded on the page |
| `/admission-enquiry` | Form submits |
| `/contact` | Phone, map/address |
| `/admin` | Dashboard checklist widget |

---

## After content is ready
- Replace placeholder phone/email in `.env` if you add mail later.
- Phase **E**: deploy to VPS (`npm run build`, Nginx, SSL). See `SETUP.md`.
