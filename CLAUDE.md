# Sportshandicapper.com — Claude Context File

Read this file at the start of every session. This is a white-label clone of INSPIN built by Jay Yagma.

---

## What This Project Is

**Sportshandicapper.com** is a professional sports betting analysis platform — a clone of INSPIN (inspin.com) with a completely different design and brand. Same Laravel codebase, different look, separate members database, but **shares picks and articles with INSPIN**.

- **Original project:** INSPIN — folder: `inspin-2026-03-12/inspin-rebuild-laravel` on Jay's computer
- **This project:** Sportshandicapper — folder: `sportshandicapper-laravel` on Jay's computer
- **Relationship:** Same codebase. Picks and articles come from INSPIN's database (read-only). Members/users are in a separate Sportshandicapper database.
- **All design work and feature work is done in THIS folder** — not the INSPIN folder

---

## Current Status (as of May 2026)

- [x] GitHub repo created and connected — `developervrb506/sportshandicapper-site` (branch: `main`)
- [x] Domain live — sportshandicapper.com is accessible
- [x] Server is the same as INSPIN — `192.250.227.216` (user: `handicap`)
- [x] CI/CD configured — git push to `main` auto-deploys to server
- [x] AI chatbot system prompt updated for Sportshandicapper branding
- [x] Shared INSPIN database connection configured for picks and articles
- [x] Database SQL sent to client (Alexis) for import
- [ ] Design NOT yet applied — still shows INSPIN gold theme, needs indigo redesign
- [ ] SSL not yet installed — site shows "Not Secure"
- [ ] Sportshandicapper .env not yet configured on server (needs INSPIN DB credentials added)
- [ ] Admin account not yet created on server

---

## How to Push Code (Deployment)

**This is different from INSPIN.** Push to `main` on a different repo:

```bash
git add .
git commit -m "your message"
git push origin develop:main
```

The server auto-deploys when `main` is updated. No SSH needed.

| | INSPIN | Sportshandicapper |
|---|---|---|
| Repo | `developervrb506/inspin-site` | `developervrb506/sportshandicapper-site` |
| Branch | `develop` | `main` |
| Deploy | auto on push | auto on push |
| Server folder | `~/inspin.com` | `~/sportshandicapper.com` |

---

## Database Architecture

Sportshandicapper uses **two database connections**:

| Connection | What it stores | Config key |
|---|---|---|
| `mysql` (default) | Members, users, subscriptions, packages | `DB_*` in .env |
| `inspin` | Picks, articles (read from INSPIN) | `INSPIN_DB_*` in .env |

The `Pick` and `Article` models use `protected $connection = 'inspin'` — they read directly from INSPIN's database. When Jay adds picks or articles on INSPIN, they automatically appear on Sportshandicapper.

**.env additions needed on Sportshandicapper server:**
```
INSPIN_DB_HOST=127.0.0.1
INSPIN_DB_DATABASE=inspin_db
INSPIN_DB_USERNAME=inspin_user
INSPIN_DB_PASSWORD=the_inspin_db_password
```

---

## Tech Stack

- **Backend:** Laravel 9, PHP 8
- **Frontend:** Blade templates, vanilla CSS (CSS variables), vanilla JavaScript
- **Database:** MySQL — two connections (own DB for members, INSPIN DB for picks/articles)
- **No React, no Vue, no Tailwind** — pure Laravel/Blade

---

## Design Specification (NOT YET APPLIED)

Replace every instance of INSPIN's gold `#FDB515` with indigo `#6366F1`.

### CSS Variables
```css
:root {
    --gold:   #6366F1;    /* Electric indigo — replaces INSPIN gold #FDB515 */
    --bg:     #060818;    /* Deep navy-black background */
    --card:   #0D1224;    /* Card background */
    --inner:  #111827;    /* Inner card background */
    --bdr:    rgba(99,102,241,0.15); /* Indigo-tinted border */
}
```

### Accent Colors
- Primary: `#6366F1` (electric indigo)
- Secondary: `#3B82F6` (royal blue)
- Tertiary: `#8B5CF6` (soft violet — use sparingly for premium badges)
- Gradient: `linear-gradient(135deg, #6366F1, #3B82F6)`
- Glow: `rgba(99,102,241,0.2)` behind hero and featured elements

### Typography
- **Title font:** Space Grotesk (headings, nav, numbers)
- **Body font:** DM Sans (body text, descriptions)
- Google Fonts link: `https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap`

### Layout Style
- **Analytics-first** — data panels and stats visible above the fold
- NOT hero-first like INSPIN
- Numbers and live pick previews lead the page
- Feels like a Bloomberg terminal / fintech dashboard for sports

---

## Server & Credentials

- **Server:** `192.250.227.216` (same server as INSPIN)
- **SSH user:** `handicap`
- **SSH key:** `C:\Users\jayya\OneDrive\Desktop\ALL OF MY FILES\WarrantyFiles\New client\inspin-2026-03-12\jay_key.ppk`
- **Passphrase:** `ZH-72kRpsfvcs}o!`
- **Server folder:** `~/sportshandicapper.com`
- **Domain:** `sportshandicapper.com`

---

## Key Differences from INSPIN

| Feature | INSPIN | Sportshandicapper |
|---|---|---|
| Color accent | Gold `#FDB515` | Indigo `#6366F1` |
| Font | Inter | Space Grotesk + DM Sans |
| Layout | Hero-first | Analytics-first |
| Brand name | INSPIN | Sportshandicapper |
| Domain | inspin.com | sportshandicapper.com |
| GitHub repo | `developervrb506/inspin-site` | `developervrb506/sportshandicapper-site` |
| Push branch | `develop` | `main` |
| Members DB | inspin_db | sportshandicapper_db |
| Picks/Articles | Own data | Shared from INSPIN DB |

---

## What Still Needs To Be Done

1. **Apply the design** — change all gold to indigo, swap fonts to Space Grotesk + DM Sans, redesign homepage to analytics-first layout
2. **Configure server .env** — add INSPIN DB credentials so picks and articles load
3. **Install SSL** — site currently shows "Not Secure"
4. **Create admin account** on server via `php artisan tinker`
5. **Test the full site** — registration, picks, articles, subscriber portal

---

## Jay's Workflow

Jay manages both INSPIN and Sportshandicapper from separate VS Code windows.
- INSPIN work → open `inspin-2026-03-12/inspin-rebuild-laravel` in VS Code
- Sportshandicapper work → open `sportshandicapper-laravel` in VS Code (this folder)
- Adding picks/articles is done on INSPIN only — Sportshandicapper reads them automatically
