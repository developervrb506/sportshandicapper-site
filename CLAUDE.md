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

## Current Status (as of May 27, 2026)

### Completed
- [x] GitHub repo created and connected — `developervrb506/sportshandicapper-site` (branch: `main`)
- [x] Domain live — sportshandicapper.com is accessible
- [x] Server is the same as INSPIN — `192.250.227.216` (user: `handicap`)
- [x] CI/CD configured — git push to `main` auto-deploys to server (confirmed working by client Alexis, May 27 2026)
- [x] IMPORTANT: Do NOT edit files directly on the server — all changes must go through GitHub
- [x] AI chatbot system prompt updated for Sportshandicapper branding
- [x] Shared INSPIN database connection configured for picks and articles
- [x] Database SQL sent to client (Alexis) for import
- [x] Full new design applied — dark navy background, solid blue `#1E90FF` accent, Inter font
- [x] Design based on custom prototype: https://github.com/jayyagma4/sportshandicap-pro
- [x] Aurora background (2-blob, canvas particles, noise overlay, vignette)
- [x] Floating pill navigation bar
- [x] Hero section with ROI Simulator card
- [x] Two-column auth modal (login + register with disclaimer step, sliding tab, no Google/Apple)
- [x] Articles section — live, pulls from DB, falls back to static sample articles when DB is empty
- [x] Active Picks section — live, pulls from DB, falls back to static sample picks when DB is empty
- [x] Trust stats bar (units won, track record, sports covered, win rate)
- [x] Membership Packages section — centered heading, 6 solid dark cards, eyebrow tags, correct features per tier
- [x] Data & Tools section (4 cards — marked Soon)
- [x] About Us section with stat cards
- [x] Footer fixed (z-index issue resolved), logo enlarged
- [x] Package database seeded locally (9 packages)
- [x] SQLite local dev database configured

### Still In Progress
- [ ] Design refinements: Exclusive Articles, Active Picks, Packages, Data & Tools, About Us sections
- [ ] SSL not yet installed — site shows "Not Secure"
- [ ] Sportshandicapper .env not yet configured on server (needs INSPIN DB credentials added)
- [ ] Admin account not yet created on server
- [ ] User dashboard — to be built after landing page design is finalized

---

## How to Push Code (Deployment)

Always use this exact workflow — no exceptions, never use force push:

```bash
git pull origin main
git status
git add .
git commit -m "your message"
git push origin main
```

NEVER use `--force`. The server auto-deploys when `main` is updated.
Never edit files directly on the server.

**Resolved:** The INSPIN database password on the server was incorrect and was breaking the deploy. This has been fixed — auto-deploy now works correctly.

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

**Local dev uses SQLite** — absolute path configured in `.env` with forward slashes.

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
- **Local dev server:** `php artisan serve --port=8001` at http://localhost:8001

---

## Current Design System

### Colors
- Background: `#060818` (deep navy-black)
- Card background: `#0C1020`
- Primary accent: `#1E90FF` (solid blue — buttons, badges, highlights)
- Cyan accent: `#22D3EE` (confidence numbers, vivid text)
- Border: `rgba(255,255,255,0.08)` default, `rgba(30,144,255,0.4)` hover

### Typography
- **All fonts:** Inter (Google Fonts) — replaced Space Grotesk + DM Sans
- Body: `font-family: 'Inter', system-ui, sans-serif`

### Key CSS Classes
- `btn-primary` — solid `#1E90FF`, pill shape, hover darkens to `#1873cc`
- `btn-secondary` — transparent, white border, hover slight white bg
- `card-premium` — `#0C1020` bg, white border, hover lifts
- `pkg-card` — package card, solid `#0C1020`, `pkg-card.highlight` has blue border glow
- `gradient-text` — plain white `#ffffff`
- `gradient-text-vivid` — cyan `#22D3EE`
- `eyebrow` — small uppercase tracking label
- `section-h2` — main section heading

### z-index Layering
- `#aurora-bg` — `position:fixed; z-index:0`
- `#site-content` — `position:relative; z-index:1`
- Footer — `position:relative; z-index:1`
- Nav — `position:fixed; z-index:150`

---

## Package Slugs and Tiers

| Slug | Name | Price |
|---|---|---|
| `free-trial` | Free Trial | $0 |
| `1-week` | 1 Week | $24.99 |
| `2-weeks` | 2 Weeks | $49.99 |
| `monthly` | 1 Month | $99.99 (Most Popular) |
| `quarterly` | 3 Months | $199.99 |
| `semi-annual` | 6 Months | $299.99 |

Featured slugs shown on landing page: `['free-trial','1-week','2-weeks','monthly','quarterly','semi-annual']`

---

## What Still Needs To Be Done

1. **Design refinements** — Exclusive Articles, Active Picks, Packages, Data & Tools, About Us sections all need final polish to match the prototype
2. **Configure server .env** — add INSPIN DB credentials so real picks and articles load on the live site
3. **Install SSL** — site currently shows "Not Secure"
4. **Create admin account** on server via `php artisan tinker`
5. **Test the full site** — registration, picks, articles, subscriber portal
6. **User Dashboard** — build after landing page design is fully finalized

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
| Color accent | Gold `#FDB515` | Blue `#1E90FF` |
| Font | Inter | Inter |
| Layout | Hero-first | Analytics-first |
| Brand name | INSPIN | Sportshandicapper |
| Domain | inspin.com | sportshandicapper.com |
| GitHub repo | `developervrb506/inspin-site` | `developervrb506/sportshandicapper-site` |
| Push branch | `develop` | `main` |
| Members DB | inspin_db | sportshandicapper_db |
| Picks/Articles | Own data | Shared from INSPIN DB |

---

## Jay's Workflow

Jay manages both INSPIN and Sportshandicapper from separate VS Code windows.
- INSPIN work → open `inspin-2026-03-12/inspin-rebuild-laravel` in VS Code
- Sportshandicapper work → open `sportshandicapper-laravel` in VS Code (this folder)
- Adding picks/articles is done on INSPIN only — Sportshandicapper reads them automatically
- Design prototype reference: https://github.com/jayyagma4/sportshandicap-pro
- Never edit files directly on the server — client Alexis confirmed all changes go through GitHub only