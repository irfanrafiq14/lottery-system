# Weekly Reward Draw System
## Complete Documentation — Setup to Production

**Version:** 1.0  
**Framework:** Laravel 12  
**Database:** MySQL  
**Frontend:** Blade + Tailwind CSS  
**Real-time:** Laravel Reverb (WebSockets)

---

## Table of Contents

1. [System Overview](#1-system-overview)
2. [Requirements](#2-requirements)
3. [Installation (XAMPP / Windows)](#3-installation-xampp-windows)
4. [Environment Configuration](#4-environment-configuration)
5. [Running the Application](#5-running-the-application)
6. [Default Credentials](#6-default-credentials)
7. [User Guide](#7-user-guide)
8. [Admin Guide](#8-admin-guide)
9. [Weekly Draw & Reset System](#9-weekly-draw--reset-system)
10. [Real-Time Updates (WebSockets)](#10-real-time-updates-websockets)
11. [Email System](#11-email-system)
12. [Production Deployment](#12-production-deployment)
13. [Troubleshooting](#13-troubleshooting)
14. [Export to PDF](#14-export-to-pdf)
15. [Project Structure](#15-project-structure)
16. [Artisan Commands Reference](#16-artisan-commands-reference)

---

## 1. System Overview

**Weekly Reward Draw System** is a web application that manages three weekly reward pools:

| Pool   | Entry Fee | Draw Frequency        |
|--------|-----------|------------------------|
| Bronze | 10 PKR    | Every Friday at 00:00 |
| Silver | 50 PKR    | Every Friday at 00:00 |
| Gold   | 100 PKR   | Every Friday at 00:00 |

### Core features

- User registration, login, and **email OTP verification**
- Manual payment submission (transaction ID + screenshot)
- Admin approval workflow for entries
- **Weekly automated draw** — 1 winner per pool
- **Weekly reset** — soft-delete entries, reopen pools, notify all users
- **Real-time updates** via WebSockets (admin + user dashboards)
- Mobile-first responsive UI (Tailwind CSS)

### High-level flow

```
User registers → OTP email verification → Join pool → Submit payment proof
    → Admin approves entry → Friday draw selects winner → Emails sent
    → Entries soft-deleted → Pools reopen → Users re-enter for new week
```

---

## 2. Requirements

### Server requirements

| Component   | Minimum Version |
|-------------|-----------------|
| PHP         | 8.2+            |
| MySQL       | 5.7+ / MariaDB 10.3+ |
| Composer    | 2.x             |
| Node.js     | 18+             |
| npm         | 9+              |

### PHP extensions

- BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML

### Optional (production)

- Supervisor (for Reverb + scheduler)
- SMTP mail server
- SSL certificate (HTTPS)

---

## 3. Installation (XAMPP / Windows)

### Step 1: Clone or copy project

Place the project in your web root:

```
C:\xampp\htdocs\lottery-system
```

### Step 2: Install PHP dependencies

```bash
cd C:\xampp\htdocs\lottery-system
composer install
```

### Step 3: Install Node dependencies & build assets

```bash
npm install
npm run build
```

For development with hot reload:

```bash
npm run dev
```

### Step 4: Environment file

```bash
copy .env.example .env
php artisan key:generate
```

Edit `.env` with your database and mail settings (see [Section 4](#4-environment-configuration)).

### Step 5: Create MySQL database

Start **MySQL** in XAMPP Control Panel, then:

```bash
mysql -u root -e "CREATE DATABASE lottery_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Or create `lottery_system` via phpMyAdmin.

### Step 6: Run migrations and seeders

```bash
php artisan migrate --seed
```

This creates all tables and seeds:
- Bronze, Silver, Gold pools
- Default admin account

### Step 7: Storage link

```bash
php artisan storage:link
```

Payment screenshots are stored in `storage/app/public/payments` and served via `public/storage`.

### Step 8: Fix soft-deletes column (if needed)

If you see `Unknown column 'entries.deleted_at'`:

```bash
php artisan entries:repair-soft-deletes
php artisan migrate
```

---

## 4. Environment Configuration

### Application

```env
APP_NAME="Weekly Reward Draw"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

For XAMPP without `artisan serve`:

```env
APP_URL=http://localhost/lottery-system/public
```

### Database (MySQL)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lottery_system
DB_USERNAME=root
DB_PASSWORD=
```

### Mail (SMTP example — Gmail)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Weekly Reward Draw"
```

For local testing without SMTP:

```env
MAIL_MAILER=log
```

Emails are written to `storage/logs/laravel.log`.

### Broadcasting / WebSockets (Reverb)

```env
BROADCAST_CONNECTION=reverb
QUEUE_CONNECTION=sync

REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

Generate Reverb keys:

```bash
php artisan tinker --execute="echo Str::random(20);"
```

---

## 5. Running the Application

### Option A: Development (recommended)

Run all services at once:

```bash
composer run dev
```

This starts:
- Laravel server (`php artisan serve`)
- Reverb WebSocket server
- Log viewer (Pail)
- Vite dev server

### Option B: Manual (separate terminals)

**Terminal 1 — Web server:**
```bash
php artisan serve
```
App URL: `http://127.0.0.1:8000`

**Terminal 2 — WebSocket server:**
```bash
php artisan reverb:start
```

**Terminal 3 — Frontend (development only):**
```bash
npm run dev
```

### Option C: XAMPP Apache

1. Start Apache + MySQL in XAMPP
2. Start Reverb: `php artisan reverb:start`
3. Open: `http://localhost/lottery-system/public`

Ensure `mod_rewrite` is enabled and `.htaccess` in `public/` is active.

### Connection indicator

- **Green dot** in header = WebSocket connected
- **Red dot** = Reverb not running

---

## 6. Default Credentials

| Role  | URL                        | Email                   | Password   |
|-------|----------------------------|-------------------------|------------|
| Admin | `/admin/login`             | `admin@rewarddraw.test` | `password` |
| User  | `/register` (create new)   | —                       | —          |

**Change the admin password immediately in production.**

---

## 7. User Guide

### 7.1 Registration

1. Go to `/register`
2. Enter name, email, password
3. After registration you are redirected to **OTP verification**

### 7.2 Email OTP verification

- A **6-digit OTP** is sent to your email
- OTP expires in **10 minutes**
- Resend is available after **60 seconds** cooldown
- You must verify before accessing pools

### 7.3 Dashboard

After verification, `/dashboard` shows:

- **Bronze / Silver / Gold** pool cards
- Entry fee and participant count
- Countdown to next Friday draw
- **New Week Started** banner (after weekly reset)
- **Verified User** badge

### 7.4 Joining a pool

1. Click **Join Pool** on an open pool
2. Transfer the exact entry fee (10 / 50 / 100 PKR) via your payment method
3. Submit:
   - **Transaction ID** (must be unique)
   - **Payment screenshot** (JPEG/PNG/WebP, max 5MB)
4. Entry status becomes **Pending** until admin approval

### 7.5 Entry rules

- One entry per pool per week
- Only **approved** entries participate in the draw
- Entries do **not** carry over — re-enter every week after reset
- Email verification is mandatory

---

## 8. Admin Guide

Admin panel URL: `/admin/login`

### 8.1 Dashboard

Shows live stats:
- Total users
- Pending / approved entries
- Total winners
- Recent entries table (updates in real-time)

### 8.2 Manage entries

**Path:** `/admin/entries`

- View all entries with status filters
- Click **Review** to see payment screenshot
- **Approve** — user becomes eligible for draw
- **Reject** — entry excluded from draw

### 8.3 Manage pools

**Path:** `/admin/pools`

- View entry counts per pool
- **Open / Close** pools manually

### 8.4 Users

**Path:** `/admin/users`

- List all registered users
- Verification status and entry count

### 8.5 Winners history

**Path:** `/admin/winners`

- All past draw winners by pool and week

### 8.6 Weekly draw

**Path:** `/admin/draw`

**Run Draw & Reset Manually** executes the full weekly flow:

1. Lock all pools
2. Select 1 winner per pool (approved + verified users only)
3. Send winner emails
4. Soft-delete all entries for the week
5. Reopen pools
6. Send reset email to all verified users

---

## 9. Weekly Draw & Reset System

### Automated schedule

Every **Friday at 00:00** (app timezone):

```bash
php artisan draw:weekly
```

Registered in `routes/console.php`. Requires cron:

```bash
* * * * * cd /path/to/lottery-system && php artisan schedule:run >> /dev/null 2>&1
```

### Manual draw

```bash
php artisan draw:weekly
```

Optional week override:

```bash
php artisan draw:weekly --week=202627
```

### Winner selection rules

For each pool:
- Only **approved** entries
- Only **email-verified** users
- Random selection of **1 winner**
- Stored in `winners` table with `week_number`

### Weekly reset

After draw:
- All entries for that week are **soft-deleted** (`deleted_at` set)
- Pools reopen for new entries
- Users must re-enter — no carry-over

### Emails sent

| Email              | Recipients           | Subject                              |
|--------------------|----------------------|--------------------------------------|
| Winner notification| Winners only         | Congratulations! You Won…            |
| Weekly reset       | All verified users   | New Weekly Draw Started - Join Now   |

---

## 10. Real-Time Updates (WebSockets)

Powered by **Laravel Reverb** + **Laravel Echo**.

### Events that trigger live updates

| Action              | User dashboard      | Admin panel         |
|---------------------|---------------------|---------------------|
| Entry submitted     | Status + toast      | New row + stats     |
| Entry approved/rejected | Status toast    | Stats + row update  |
| Pool toggled        | Pool badges         | Toast               |
| Draw completed      | Pools reset         | Stats refresh       |

### Channels

| Channel            | Type    | Audience        |
|--------------------|---------|-----------------|
| `pools`            | Public  | Everyone        |
| `admin.dashboard`  | Private | Admins only     |
| `user.{id}`        | Private | Specific user   |

### Start Reverb

```bash
php artisan reverb:start
```

Production: run Reverb under Supervisor (see [Section 12](#12-production-deployment)).

---

## 11. Email System

### OTP email

- Sent on registration and OTP resend
- Template: `resources/views/emails/otp.blade.php`
- 6-digit code, 10-minute expiry

### Winner email

- Sent after weekly draw to winners
- Template: `resources/views/emails/winner.blade.php`
- Includes pool name, prize, week number

### Weekly reset email

- Sent to all verified users after draw
- Template: `resources/views/emails/weekly-reset.blade.php`
- Lists last week's winners + join CTA

### Debug emails locally

```env
MAIL_MAILER=log
```

Check `storage/logs/laravel.log` for email content.

---

## 12. Production Deployment

### Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Run `php artisan config:cache`, `route:cache`, `view:cache`
- [ ] Run `npm run build`
- [ ] Configure real SMTP mail
- [ ] Change default admin password
- [ ] Set up SSL (HTTPS) — update `REVERB_SCHEME=https`
- [ ] Point web server document root to `public/`
- [ ] Set up cron for scheduler
- [ ] Run Reverb under Supervisor
- [ ] Set correct `APP_URL`

### Apache virtual host example

```apache
<VirtualHost *:80>
    ServerName rewarddraw.example.com
    DocumentRoot "C:/xampp/htdocs/lottery-system/public"

    <Directory "C:/xampp/htdocs/lottery-system/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Cron (Windows Task Scheduler)

Program: `C:\xampp\php\php.exe`  
Arguments: `C:\xampp\htdocs\lottery-system\artisan schedule:run`  
Trigger: Every 1 minute

### Supervisor — Reverb (Linux)

```ini
[program:reverb]
command=php /var/www/lottery-system/artisan reverb:start
autostart=true
autorestart=true
user=www-data
```

### File permissions

Ensure writable:
- `storage/`
- `bootstrap/cache/`

---

## 13. Troubleshooting

### `Unknown column 'entries.deleted_at'`

```bash
php artisan entries:repair-soft-deletes
php artisan migrate
php artisan config:clear
```

### WebSocket not connecting (red dot)

1. Ensure Reverb is running: `php artisan reverb:start`
2. Check `.env` Reverb variables match `VITE_REVERB_*`
3. Rebuild assets: `npm run build`
4. Clear config: `php artisan config:clear`

### Emails not sending

1. Verify SMTP credentials in `.env`
2. For Gmail, use an **App Password** (not your login password)
3. Test with `MAIL_MAILER=log` first

### Duplicate transaction ID error

Each transaction ID must be unique across active (non-deleted) entries.

### Migration fails on unique index drop

Run:

```bash
php artisan migrate
```

The repair migration handles partial states automatically.

### `Nothing to migrate` but column missing

```bash
php artisan entries:repair-soft-deletes
```

### Draw selects no winners

- Ensure entries are **approved**
- Users must be **email verified**
- Check entries exist for current `week_number`

---

## 14. Export to PDF

### Option A: Browser print

1. Open `docs/WEEKLY-REWARD-DRAW-SYSTEM.md` in VS Code or GitHub
2. Use a Markdown preview extension
3. Print → Save as PDF

### Option B: Pandoc (if installed)

```bash
cd docs
pandoc WEEKLY-REWARD-DRAW-SYSTEM.md -o WEEKLY-REWARD-DRAW-SYSTEM.pdf --pdf-engine=xelatex -V geometry:margin=1in
```

Install Pandoc: https://pandoc.org/installing.html

### Option C: Online converter

Upload `docs/WEEKLY-REWARD-DRAW-SYSTEM.md` to any Markdown-to-PDF converter.

---

## 15. Project Structure

```
lottery-system/
├── app/
│   ├── Console/Commands/
│   │   ├── WeeklyDrawCommand.php      # Friday draw cron
│   │   └── RepairEntriesSoftDeletesCommand.php
│   ├── Events/
│   │   └── RealtimeUpdate.php         # WebSocket broadcast event
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                  # Login, register
│   │   │   ├── Admin/                 # Admin panel
│   │   │   ├── DashboardController.php
│   │   │   ├── EntryController.php
│   │   │   └── OtpVerificationController.php
│   │   └── Middleware/
│   ├── Mail/                          # OTP, winner, reset emails
│   ├── Models/                        # User, Admin, Pool, Entry, Winner, EmailOtp
│   └── Services/
│       ├── DrawService.php            # Winner selection, soft-delete
│       ├── EmailService.php           # Winner + reset emails
│       ├── OtpService.php             # OTP generation/verification
│       ├── RealtimeService.php        # WebSocket broadcasts
│       └── WeeklyDrawService.php      # Full weekly orchestration
├── database/migrations/               # Schema definitions
├── docs/                              # This documentation
├── resources/
│   ├── js/                            # Echo + realtime handlers
│   └── views/                         # Blade templates
├── routes/
│   ├── web.php                        # All web routes
│   ├── channels.php                   # Broadcast channel auth
│   └── console.php                    # Scheduler
└── public/                            # Web root (point server here)
```

### Database tables

| Table        | Purpose                              |
|--------------|--------------------------------------|
| users        | Registered users                     |
| admins       | Admin accounts                       |
| email_otps   | OTP codes (6-digit, 10 min expiry)   |
| pools        | Bronze, Silver, Gold pools           |
| entries      | Payment submissions (soft-deletes)   |
| winners      | Weekly draw results                  |

---

## 16. Artisan Commands Reference

| Command                              | Description                              |
|--------------------------------------|------------------------------------------|
| `php artisan migrate --seed`         | Run migrations + seed pools & admin      |
| `php artisan storage:link`           | Link public storage for screenshots      |
| `php artisan serve`                  | Start development web server             |
| `php artisan reverb:start`           | Start WebSocket server                   |
| `php artisan draw:weekly`            | Run weekly draw + reset manually         |
| `php artisan schedule:list`          | View scheduled tasks                     |
| `php artisan schedule:run`           | Run scheduler (use in cron)              |
| `php artisan entries:repair-soft-deletes` | Fix missing deleted_at column     |
| `php artisan config:clear`           | Clear cached configuration               |
| `php artisan route:list`             | List all application routes              |
| `composer run dev`                   | Start server + reverb + vite + logs      |

---

## Route Reference

### User routes

| Method | URL                    | Name            |
|--------|------------------------|-----------------|
| GET    | /login                 | login           |
| POST   | /login                 | —               |
| GET    | /register              | register        |
| POST   | /register              | —               |
| POST   | /logout                | logout          |
| GET    | /verify-email          | otp.show        |
| POST   | /verify-email          | otp.verify      |
| POST   | /verify-email/resend   | otp.resend      |
| GET    | /dashboard             | dashboard       |
| GET    | /pools/{pool}/enter    | entries.create  |
| POST   | /pools/{pool}/enter    | entries.store   |

### Admin routes

| Method | URL                          | Name                |
|--------|------------------------------|---------------------|
| GET    | /admin/login                 | admin.login         |
| GET    | /admin/dashboard             | admin.dashboard     |
| GET    | /admin/entries               | admin.entries.index |
| PATCH  | /admin/entries/{entry}/approve | admin.entries.approve |
| PATCH  | /admin/entries/{entry}/reject  | admin.entries.reject  |
| GET    | /admin/pools                 | admin.pools.index   |
| GET    | /admin/users                 | admin.users.index   |
| GET    | /admin/winners               | admin.winners.index |
| GET    | /admin/draw                  | admin.draw.index    |
| POST   | /admin/draw/run              | admin.draw.run      |

---

*Documentation generated for Weekly Reward Draw System — Laravel 12*
