# Product Requirements Document (PRD)
## INSPIN.com - Sports Betting Analysis Platform

---

### 1. Product Overview

**Product Name:** INSPIN.com  
**Type:** Sports Betting Analysis & Handicapping Platform  
**Current Stage:** MVP Development — Bug Fix & Feature Completion Phase  
**Target Launch:** Q2 2026  
**Repo:** https://github.com/jayyagma4/inspin

INSPIN.com is a sports betting analysis platform that provides expert picks, betting consensus data, live odds comparison, and simulation model insights for NFL, NBA, MLB, NHL, and NCAA sports. The platform operates on a freemium model with free picks available publicly and premium picks behind a subscription paywall.

---

### 2. Problem Statement

Sports bettors lack access to data-driven, simulation-backed picks and real-time consensus data. Most handicappers provide picks without transparency on win rates, public betting splits, or sharp money movement. INSPIN solves this by offering a simulation model that has tracked +150 units over 3 years, combined with public betting consensus data and expert analysis.

---

### 3. Target Users

| User Type | Description | Access Level |
|-----------|-------------|-------------|
| **Free User** | Casual bettor browsing free content | Free picks, basic articles, basic consensus |
| **Member** | Subscribed user | Full picks access, premium articles, all consensus data |
| **Whale Member** | Premium subscriber | Exclusive whale picks (10-star), direct line access, priority support |
| **Admin** | Platform operator | Full content management, user management, analytics |

---

### 4. Core Features — Current Status

#### 4.1 Public Website
| Feature | Description | Status | Notes |
|---------|-------------|--------|-------|
| Homepage | Hero, expert picks carousel, articles grid, packages, sports grid | ✅ Done | Shows Pick model (not old Tips), team logos, featured images |
| Expert Picks Page | Sport-filtered picks list with logos and details | ✅ Done | Uses new Pick model with filters |
| Articles Page | Sport/category filters, pagination, featured images | ✅ Done | Shows featured images on cards |
| Article Detail | Full article with related picks and articles, premium gate | ✅ Done | Premium content lock for free users |
| Top Consensus | Public betting splits with 6-sport filter | ✅ Done | Fixed: sport filter now uses NFL/NBA not Football/Basketball |
| Live Odds | Odds comparison table | ✅ Done | Fixed: null-safe date display |
| Trends | Betting trends overview | ✅ Done | — |
| Join Page | All packages + whale packages in unified grid | ✅ Done | — |
| About / Reviews / Bitcoin | Static info pages | ✅ Done | — |
| Betting Tools | Placeholder calculator page | ✅ Done | Marked "Coming Soon" |

#### 4.2 Authentication & Membership
| Feature | Description | Status | Notes |
|---------|-------------|--------|-------|
| Sign In | Email/password login with remember me | ✅ Done | — |
| Sign Up | Registration with name, email, phone, password | ✅ Done | — |
| Forgot/Reset Password | Email-based password reset flow | ✅ Done | Just added: ResetPasswordController + reset-password view |
| User Profile | Account details, role, support tickets | ✅ Done | — |
| Premium Content Gate | Lock premium articles for non-subscribers | ✅ Done | — |
| Subscription Middleware | Role-based access control (free/member/vip/admin) | ✅ Done | — |

#### 4.3 Admin Panel
| Feature | Description | Status | Notes |
|---------|-------------|--------|-------|
| Dashboard | Stats overview (picks, tickets, contests, articles) | ✅ Done | Fixed: uses Pick model, not Tip |
| Picks CRUD | Create/edit/delete picks with team logos, stars, simulation | ✅ Done | Team logo quick-fill selector added |
| Articles CRUD | Create/edit articles with featured images, rich editor | ✅ Done | Quill editor replaces TinyMCE |
| Experts CRUD | Manage experts (name, specialty, avatar) | ✅ Done | — |
| Whale Packages CRUD | Manage whale-specific packages | ✅ Done | — |
| Users Management | Edit roles, view users | ✅ Done | — |
| Support Tickets | View/manage tickets | ✅ Done | — |
| Contests | Manage contests | ✅ Done | — |

#### 4.4 Data Layer
| Model | Description | Status | Notes |
|-------|-------------|--------|-------|
| Pick | New picks model (replaces Tip) with teams, logos, stars, simulation | ✅ Done | Structured data with team1/team2, sport, rotation numbers |
| Article | Blog posts with categories, sports, premium flag, featured image | ✅ Done | — |
| BettingConsensus | Game odds with public/money percentages | ✅ Done | — |
| Package | Regular subscription plans (7 tiers from Free to Whale) | ✅ Done | — |
| WhalePackage | Premium whale-specific packages | ✅ Done | Currently 1: NFL Whale Package |
| TeamLogo | Pre-loaded team logos for quick pick creation | ✅ Done | 50 teams across 6 sports |
| Expert | Expert handicappers with specialties | ✅ Done | — |
| SupportTicket | Customer support tickets | ✅ Done | — |
| Contest | Betting contests | ✅ Done | — |
| User | Auth with phone, role (free/member/vip/admin) | ✅ Done | — |

---

### 5. Subscription Plans

#### Regular Packages
| Plan | Price | Duration | Key Features |
|------|-------|----------|-------------|
| Free Trial | $0 | 7 days | Limited picks, basic articles |
| 1 Week | $24.99 | 7 days | All picks, consensus, trends |
| 2 Weeks | $49.99 | 14 days | All picks, consensus, trends |
| 1 Month | $99.99 | 30 days | All picks, consensus, trends, support |
| 3 Months | $199.99 | 90 days | All picks, consensus, trends, support (save $100) |
| 6 Months | $299.99 | 180 days | All picks, consensus, trends, support (save $300) |
| 9 Months | $399.99 | 270 days | All picks, consensus, trends, support |
| 12 Months | $499.99 | 365 days | All picks, consensus, trends, priority support |
| Whale Package | $999.99 | 365 days | Everything + whale exclusive picks, direct line access |

#### Whale-Specific Packages
| Plan | Price | Duration | Key Features |
|------|-------|----------|-------------|
| NFL Whale Package | $499.99 | 120 days (season) | All NFL picks, exclusive whale analysis, direct line access, priority support, custom bet sizing |

> **Note:** Currently, "Whale Package" (regular, $999.99) and "NFL Whale Package" ($499.99) are two separate models/tables. These should eventually be unified into a single packages system with a `type` field.

---

### 6. Tech Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| Framework | Laravel | 9.x |
| Language | PHP | 8.2+ |
| Frontend | Blade Templates + Inline CSS | — |
| Rich Text Editor | Quill (CDN) | — |
| Database | SQLite (dev) / MySQL 8 (prod) | — |
| Auth | Custom (Breeze-style) | — |
| Server | PHP Built-in (dev) / Nginx + PHP-FPM (prod) | — |
| File Storage | Laravel Storage (local/public disk) | — |
| Package Manager | Composer + NPM | — |
| Asset Compilation | Laravel Mix | — |

---

### 7. Data Summary (Current)

| Table | Records | Source |
|-------|---------|--------|
| Picks | 1 | Seeded (new structured model) |
| Articles | 18 | 1 with featured image + 17 seeded |
| Users | 9 | 1 admin + 8 seeded |
| Betting Consensus | 12 | 4 real + 8 seeded |
| Packages | 9 | Seeded (7 regular + 1 whale regular + 1 free trial) |
| Whale Packages | 1 | Seeded (NFL Whale) |
| Team Logos | 50 | Seeded (NFL/NBA/NCAAF/NCAAB/MLB/NHL) |
| Support Tickets | 20 | Seeded |
| Contests | 15 | Seeded |
| Experts | 5 | Seeded |

> **Note:** The legacy `tips` table has 1,888 records from the WordPress import but is no longer used by the frontend. It can be migrated to the `picks` table or dropped.

---

### 8. Known Issues & Bugs

#### Critical (Must fix before launch)
| # | Issue | Details | Est. Hours |
|---|-------|---------|------------|
| BUG-1 | Payment/subscription not integrated | No real payment processing. Admin must manually change user roles. Stripe integration needed. | 16h |

#### High Priority (Should fix before launch)
| # | Issue | Details | Est. Hours |
|---|-------|---------|------------|
| BUG-2 | `related_article_id` is string column | Used as BelongsTo foreign key but column type is `string` instead of `unsignedBigInteger`. Can cause type mismatch bugs. | 1h |
| BUG-3 | No package-specific checkout flow | All "Get Started" buttons go to register page. No way to select a specific plan during signup. | 4h |
| BUG-4 | Email delivery not configured | MAIL_HOST=mailhog (dev only). Production needs real SMTP (SendGrid, Mailgun, etc.) | 2h |

#### Medium Priority
| # | Issue | Details | Est. Hours |
|---|-------|---------|------------|
| BUG-5 | Dual package system confusing | Regular "Whale Package" ($999.99) and sport-specific "NFL Whale Package" ($499.99) are on different models/tables. Should be unified. | 4h |
| BUG-6 | No email verification | Users can register without verifying email. Could allow spam accounts. | 2h |
| BUG-7 | Login redirect not persisted | When unauthenticated user clicks "Simulate" and logs in, they go to dashboard instead of back to the pick. | 1h |
| BUG-8 | Legacy Tip files still exist | TipController, Tip model, TipSeeder, and modules/tips views are orphaned but still in the codebase. Should be cleaned up. | 1h |

#### Low Priority
| # | Issue | Details | Est. Hours |
|---|-------|---------|------------|
| BUG-9 | `stars_display` accessor not used everywhere | Some views still use raw `str_repeat()` instead of `$pick->stars_display` | 0.5h |
| BUG-10 | No automated pick result grading | Game results must be manually entered. No API integration for auto-scoring. | 8h |

**Total estimated bug/fix hours: ~40h**

---

### 9. Remaining Work — Prioritized

#### Phase 1: Launch-Blocking Fixes (Week 1-2, ~20h)
| Task | Description | Est. Hours | Priority |
|------|-------------|------------|----------|
| STRIPE-1 | Stripe integration — subscription checkout, webhooks, customer portal | 16h | P0 |
| STRIPE-2 | Automated role assignment on payment (free → member/vip) | 2h | P0 |
| FIX-1 | Fix `related_article_id` column type to unsignedBigInteger | 1h | P0 |
| EMAIL-1 | Configure production SMTP (SendGrid/Mailgun) for password resets & notifications | 2h | P0 |

#### Phase 2: Launch-Ready Enhancements (Week 3, ~12h)
| Task | Description | Est. Hours | Priority |
|------|-------------|------------|----------|
| CHECKOUT-1 | Package-specific checkout flow (select plan → register → pay) | 4h | P1 |
| UNIFY-1 | Merge regular + whale packages into single Package model with `type` field | 4h | P1 |
| VERIFY-1 | Email verification on registration | 2h | P1 |
| CLEANUP-1 | Remove orphaned Tip files (controller, views, seeder, model if not needed) | 1h | P2 |
| CLEANUP-2 | Remove unused htdocs-upload production folder | 0.5h | P2 |
| REDIRECT-1 | Fix login redirect to return to previous page after auth | 1h | P2 |

#### Phase 3: Content & Data (Week 4, ~16h)
| Task | Description | Est. Hours | Priority |
|------|-------------|------------|----------|
| MIGRATE-1 | Migrate 1,888 legacy tips to new Pick model (map fields, preserve data) | 4h | P1 |
| IMPORT-1 | Full WordPress articles import with featured images | 4h | P2 |
| SEO-1 | SEO meta tags per article (title, description, OG image) | 2h | P2 |
| CONTENT-1 | Add 10+ real picks per sport with team logos | 4h | P1 |
| CONTENT-2 | Add 5+ real articles per sport category | 2h | P1 |

#### Phase 4: Real-Time Data (Week 5-6, ~16h)
| Task | Description | Est. Hours | Priority |
|------|-------------|------------|----------|
| ODDS-1 | Integrate live odds API (The Odds API or SportsRadar) | 8h | P2 |
| ODDS-2 | Real-time consensus data feed | 4h | P2 |
| AUTO-1 | Automated pick result grading via API | 4h | P3 |

#### Phase 5: UX & Notifications (Week 7, ~12h)
| Task | Description | Est. Hours | Priority |
|------|-------------|------------|----------|
| NOTIFY-1 | Welcome email on registration | 2h | P2 |
| NOTIFY-2 | New picks email/SMS alert for subscribers | 4h | P3 |
| NOTIFY-3 | Telegram bot for whale members | 4h | P3 |
| UX-1 | User pick history & tracking page | 6h | P3 |
| UX-2 | Bookmarked/favorite articles | 2h | P3 |

#### Phase 6: Admin Enhancements (Week 8, ~8h)
| Task | Description | Est. Hours | Priority |
|------|-------------|------------|----------|
| ANALYTICS-1 | Admin analytics dashboard (revenue, users, pick performance) | 4h | P2 |
| BULK-1 | Bulk pick import/export (CSV) | 2h | P3 |
| SCHED-1 | Content scheduling (publish articles at future date) | 2h | P3 |

#### Phase 7: Production Deployment (Week 9, ~8h)
| Task | Description | Est. Hours | Priority |
|------|-------------|------------|----------|
| See deployment checklist below | — | — | — |

---

### 10. Production Deployment Checklist

| # | Task | Status |
|---|------|--------|
| 1 | Set up MySQL 8 database on production server | ⬜ |
| 2 | Configure `.env` for production (APP_ENV=production, APP_DEBUG=false, APP_URL) | ⬜ |
| 3 | Generate new APP_KEY | ⬜ |
| 4 | Configure production SMTP (SendGrid/Mailgun credentials) | ⬜ |
| 5 | Set up Nginx + PHP-FPM 8.2+ server block | ⬜ |
| 6 | Install SSL certificate (Let's Encrypt) | ⬜ |
| 7 | Run `php artisan storage:link` for file uploads | ⬜ |
| 8 | Run `php artisan migrate --force` on production DB | ⬜ |
| 9 | Run `php artisan db:seed --force` for initial data | ⬜ |
| 10 | Configure Stripe API keys (live) in `.env` | ⬜ |
| 11 | Set up queue worker (Redis + Supervisor for `php artisan queue:work`) | ⬜ |
| 12 | Configure scheduled tasks via cron (`* * * * * php artisan schedule:run`) | ⬜ |
| 13 | Set up automated database backups (daily) | ⬜ |
| 14 | Configure error monitoring (Sentry) | ⬜ |
| 15 | Set up uptime monitoring (UptimeRobot) | ⬜ |
| 16 | Configure CDN for static assets (Cloudflare) | ⬜ |
| 17 | Set up rate limiting on auth routes | ⬜ |
| 18 | Add age verification / responsible gambling notice | ⬜ |
| 19 | Configure CORS for API endpoints | ⬜ |
| 20 | Run `php artisan config:cache` and `php artisan route:cache` | ⬜ |
| 21 | Set proper file permissions (storage/bootstrap cache writable) | ⬜ |
| 22 | Final QA pass — all pages load, all forms submit, all images display | ⬜ |

---

### 11. Production Timeline

| Phase | Duration | Deliverables |
|-------|----------|-------------|
| **Phase 1: Launch-Blocking** | Week 1-2 | Stripe payments, role assignment, DB fix, SMTP |
| **Phase 2: Launch-Ready** | Week 3 | Package checkout, unified packages, email verify, cleanup |
| **Phase 3: Content** | Week 4 | Data migration, article import, SEO, real content |
| **Phase 4: Real-Time** | Week 5-6 | Live odds API, consensus feed, auto-grading |
| **Phase 5: UX** | Week 7 | Email alerts, Telegram, user history |
| **Phase 6: Admin** | Week 8 | Analytics, bulk import, scheduling |
| **Phase 7: Deploy** | Week 9 | Production setup, SSL, monitoring, security |
| **Testing & QA** | Week 10 | Bug fixes, load testing, performance |
| **Launch** | Week 11 | Go live |

**Total Estimated Time: ~11 weeks**

---

### 12. Success Metrics

| Metric | Target |
|--------|--------|
| Monthly Active Users | 5,000+ |
| Paid Subscribers | 200+ |
| Monthly Recurring Revenue | $20,000+ |
| Pick Win Rate | 55%+ |
| User Retention (30-day) | 70%+ |
| Page Load Time | < 2 seconds |
| Uptime | 99.9% |

---

### 13. Risks & Mitigations

| Risk | Impact | Mitigation |
|------|--------|------------|
| Payment gateway delays | High | Use Stripe (well-documented, fast integration) |
| Live odds API cost | Medium | Start with free tier, cache responses |
| Content quality | High | Editorial review process before publishing |
| User acquisition | High | SEO optimization, social media, affiliate program |
| Regulatory compliance | High | Legal review, age verification, responsible gambling notices |
| Dual package confusion | Medium | Unify into single model before launch |
| Data migration errors | Medium | Test migration on staging first, keep backup |
| Server scaling | Medium | Start small, monitor load, scale with Cloudflare |

---

### 14. Admin Access

**Local Dev URL:** http://127.0.0.1:8000  
**Admin Login:** admin@inspin.local / password123  
**Admin Dashboard:** /dashboard  
**Picks Management:** /admin/picks  
**Articles Management:** /admin/articles  

---

### 15. Change Log

| Date | Version | Changes |
|------|---------|---------|
| Apr 3, 2026 | 1.0 | Initial PRD created |
| Apr 9, 2026 | 2.0 | Major update: Replaced Tips with Picks system, added team logos, featured images, password reset, fixed stars display, consensus filters, null-safe dates, team logo selector, unified PRD with known issues and deployment checklist |

---

*Document Version: 2.0*  
*Last Updated: April 9, 2026*  
*Status: MVP Complete — Launch-Blocking Fixes Needed*