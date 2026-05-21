# Sportshandicapper.com — Claude Context File

Read this file at the start of every session. This project is a white-label clone of INSPIN built by Jay Yagma.

---

## What This Project Is

**Sportshandicapper.com** is a standalone sports betting analysis platform — a clone of INSPIN (inspin.com) with a completely different design and brand. Same Laravel codebase, different look, separate database, separate members.

- **Original project:** INSPIN (`inspin-rebuild-laravel` folder on Jay's computer)
- **This project:** Sportshandicapper (`sportshandicapper-laravel` folder)
- **Relationship:** Same code base, different design and database. NOT connected to INSPIN's data.

---

## Tech Stack

- **Backend:** Laravel 9, PHP 8
- **Frontend:** Blade templates, vanilla CSS (CSS variables), vanilla JavaScript
- **Database:** MySQL (separate from INSPIN — own database on the same server)
- **No React, no Vue, no Tailwind** — pure Laravel/Blade like INSPIN

---

## Design Specification

### Colors (replace INSPIN's gold theme with this)
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
- Add to `<head>`: `https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap`

### Layout Style
- **Analytics-first** — data panels and stats visible above the fold without scrolling
- NOT hero-first like INSPIN
- Numbers and live pick previews lead the page
- Feels like a Bloomberg terminal / fintech dashboard for sports

---

## Design Reference

A Lovable prototype was built for this site (React/Vite/TanStack — visual reference only, code NOT used).
When Jay shares the Lovable URL, use it as a visual guide to rebuild in Blade/CSS.

---

## Server & Deployment

- **Server:** `192.250.227.216` (user: `handicap`)
- **SSH key:** `C:\Users\jayya\OneDrive\Desktop\ALL OF MY FILES\WarrantyFiles\New client\inspin-2026-03-12\jay_key.ppk`
- **Passphrase:** `ZH-72kRpsfvcs}o!`
- **Server folder:** `~/sportshandicapper.com` (to be created when ready to deploy)
- **Domain:** `sportshandicapper.com`
- **Database:** Separate MySQL DB — `sportshandicapper_db` (to be created on server)

### Deploy command (when ready)
```bash
cd ~/sportshandicapper.com && git pull origin develop && composer install --no-dev --optimize-autoloader && php artisan optimize:clear
```

---

## GitHub

- **New repo:** To be created by Jay on github.com (name: `sportshandicapper-site`)
- **Branch:** `develop` (same workflow as INSPIN)
- After Jay creates the repo, run:
```bash
git remote remove origin
git remote add origin https://github.com/developervrb506/sportshandicapper-site.git
git push -u origin develop
```

---

## Database Setup (when deploying to server)

1. Create DB in cPanel: `sportshandicapper_db`
2. Create user: `sh_user` with strong password
3. Assign user to DB with all privileges
4. Update `.env` on server with new DB credentials
5. Run: `php artisan migrate --force && php artisan db:seed --class=PackageSeeder`
6. Create admin account via tinker

---

## Key Differences from INSPIN

| Feature | INSPIN | Sportshandicapper |
|---|---|---|
| Color accent | Gold `#FDB515` | Indigo `#6366F1` |
| Font | Inter | Space Grotesk + DM Sans |
| Layout | Hero-first | Analytics-first |
| Brand name | INSPIN | Sportshandicapper |
| Domain | inspin.com | sportshandicapper.com |
| Database | inspin DB | sportshandicapper DB |
| Members | INSPIN members | Separate members |

---

## What Has NOT Been Done Yet

- [ ] New GitHub repo created and connected
- [ ] Design applied (colors, fonts, layout — Lovable prototype as reference)
- [ ] Homepage rebuilt to analytics-first layout
- [ ] Logo/branding changed
- [ ] Server folder created
- [ ] Database created on server
- [ ] Domain pointed to server
- [ ] SSL installed
- [ ] Deployed

---

## Jay's Workflow Note

Jay manages both INSPIN and Sportshandicapper. When working on Sportshandicapper:
- This folder (`sportshandicapper-laravel`) is open in VS Code
- INSPIN changes are made in a separate VS Code window (`inspin-rebuild-laravel`)
- Both projects live on the same server, different folders, different databases
