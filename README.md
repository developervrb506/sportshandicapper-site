<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Project TODO Plan

### Decision and Scope

- [x] Confirm backup contains WordPress database tables (`wp_*`) as source system
- [x] Confirm backup file set appears incomplete for full WP runtime (mostly media assets in `public_html`)
- [x] Choose target architecture: rebuild into Laravel
- [ ] Get missing source artifacts from hosting: full web root PHP files, active theme, plugin code, and `.htaccess`

### Assignment 1 (Reframed) - Restore and Stabilize Source for Extraction

- [x] Verify backup core parts available (`mysql/*.sql`, DNS/email metadata, partial `public_html`)
- [x] Identify WordPress footprint and plugin ecosystem from SQL dump
- [ ] Create isolated staging restore target (not production)
- [ ] Import source database to staging
- [ ] Load recovered source files from hosting into staging web root
- [ ] Fix WP runtime compatibility enough to inspect pages and flows
- [ ] Capture screenshots and flow map of old system as rebuild reference

### Laravel Rebuild Plan (Primary Delivery)

#### Phase 1 - Foundation

- [x] Create Laravel base project
- [x] Configure `.env` and app key
- [x] Configure local SQLite database
- [x] Run base migrations
- [x] Install PHP and Node dependencies
- [x] Keep local server running and verify browser access every session start

#### Phase 2 - Discovery to Laravel Modules

- [x] Extract business entities from WordPress data (users, tips, subscriptions, contests, tickets, feeds)
- [x] Map old URLs/pages into Laravel route map
- [x] Define Laravel data model and migration plan
- [x] Create import strategy from `inspin_main.sql` and related SQL files

#### Phase 3 - Core App Build

- [x] Build main layout and navigation
- [x] Build dashboard and account settings with real data
- [ ] Implement module CRUDs with validation and pagination (Tips complete, Tickets/Contests pending full CRUD)
- [x] Add admin workflows and status transitions (status update actions for Tickets and Contests)
- [x] Add data import commands for historical records

#### Phase 4 - Security and Compliance

- [ ] Add authentication and role-permission controls
- [ ] Add audit logging for sensitive actions
- [ ] Confirm legal jurisdiction requirements for betting/gambling operations
- [ ] Implement age-gating, responsible gaming notices, and policy pages if required
- [ ] Rotate all credentials and keys before any public launch

#### Phase 5 - QA and Launch

- [ ] Write feature tests for critical user journeys
- [ ] Run smoke tests against legacy behavior checklist
- [ ] Prepare staging sign-off with client
- [ ] Deploy production only after acceptance

### TODO Update Rule

- [x] Every implemented change must update this TODO status in the same commit/session

### Daily Commands

```bash
php artisan serve --host=127.0.0.1 --port=8000
php artisan migrate
php artisan test
npm run dev
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
