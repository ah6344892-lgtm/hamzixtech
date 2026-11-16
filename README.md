# HamzixTech

HamzixTech is a Laravel website and content management application for the company site, technology resources, and staff-managed publishing.

## Stack

The workspace was installed and built with:

- PHP 8.2.12
- Laravel Framework 12.72.0
- Livewire 4.4.8 and Livewire Flux UI 2.21.0
- Tailwind CSS 4.3.5 and Vite 6.4.6
- Laravel Fortify 1.42.0 for staff authentication
- Spatie Laravel Permission 6.25.0 for roles and permissions
- MySQL for application data
- Node.js 26.13.0 and npm 11.20.0

The application stays on PHP 8.2. No PHP upgrade is required.

## Features

- Responsive public website with light, dark, and system appearance
- Owner supplied HT logo at public/images/brand/hamzixtech-logo.png
- Public services, projects, blog, tutorials, templates, tools, AI tools, about, contact, privacy, and terms pages
- Search, published content filtering, sitemap, robots directives, canonical metadata, and structured data
- Markdown authoring and sanitized rendering
- Four working browser-session developer tools: JSON formatter, text utilities, slug generator, and URL encoder/decoder
- Contact form with validation, honeypot, rate limit, database storage, and optional configured email notification
- Staff-only administration for content, categories, tags, AI tool metadata, contact messages, users, roles, settings, activity, and media
- Role/policy authorization on protected routes and actions, including protection for the last active Super Admin
- No public user registration, seeded demo accounts, fabricated portfolio entries, or fake social profiles

AI tools intentionally remain unavailable until an AI provider adapter and approved credentials are configured. Adding API key values alone does not enable an unsupported provider.

## Local setup

From PowerShell in the project folder:

~~~powershell
composer install
if (-not (Test-Path .env)) { Copy-Item .env.example .env; php artisan key:generate }
npm.cmd ci
~~~

Configure .env with the local MySQL database name and credentials. Create the database if needed:

~~~sql
CREATE DATABASE hamzixtech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
~~~

Then run:

~~~powershell
php artisan migrate --seed
php artisan storage:link
php artisan hamzixtech:super-admin
npm.cmd run build
php artisan serve
~~~

The Super Admin command asks for a name, email, and password in the terminal. Passwords must be at least 12 characters. If the email already exists, the command grants the role without changing that account's password. The seeder creates roles, permissions, empty contact/social settings, and the implemented utility tools; it does not create a default user or overwrite an existing Super Admin password.

Open http://127.0.0.1:8000. Staff sign in at /login, then manage the site at /admin.

For frontend hot reload, use a second PowerShell terminal:

~~~powershell
npm.cmd run dev
~~~

Use npm.cmd if PowerShell blocks npm.ps1; do not change the execution policy.

## Configuration

Set the following values when they are available:

~~~dotenv
APP_URL=https://your-domain
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hamzixtech
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
MAIL_MAILER=smtp
HAMZIXTECH_CONTACT_EMAIL=
HAMZIXTECH_WHATSAPP_NUMBER=
HAMZIXTECH_WHATSAPP_MESSAGE=
HAMZIXTECH_UI_MODE=simple
AI_PROVIDER=
AI_API_KEY=
AI_MODEL=
~~~

Contact email, WhatsApp, social profile URLs, homepage copy, about copy, and legal page text can be maintained in /admin/settings. Leave contact and social values blank until the owner supplies the real values. Configure SMTP and a real MAIL_FROM_ADDRESS before enabling email delivery. Local development defaults to the log mailer.

`HAMZIXTECH_UI_MODE` selects the website interaction mode and defaults to `simple`. Set it to `livewire` to enable Livewire navigation and the Livewire/Flux contact form, developer tools, and admin Markdown editor. Clear the application config cache after changing the value (`php artisan config:clear`).

## Tests and build

The automated test suite uses an in-memory SQLite connection and does not write to the MySQL database:

~~~powershell
php artisan test
npm.cmd run build
~~~

The MySQL application connection uses .env. php artisan migrate --seed applies pending migrations and runs idempotent seeders. Never use migrate:fresh on a database containing data.

## Production checklist

- Set a unique APP_KEY, real database credentials, APP_ENV=production, and APP_DEBUG=false.
- Point the web server document root to Laravel's public/ directory and enable HTTPS.
- Configure production mail and contact details in /admin/settings.
- Review privacy/terms copy against the real hosting, analytics, mail, and data-retention setup.
- Add only approved portfolio content, project images, social profiles, and template licenses.
- Configure backups before production updates. A basic MySQL backup and restore pattern is:

~~~powershell
mysqldump --single-transaction -u your_database_user -p hamzixtech > hamzixtech-backup.sql
mysql -u your_database_user -p hamzixtech < hamzixtech-backup.sql
~~~

- Use the configured production PHP version to run php artisan migrate --force, then build assets with npm.cmd run build.

## Project documents

- HamzixTech_Project_Blueprint.md - original product and implementation specification
- docs/IMPLEMENTATION_STATUS.md - delivered features, checks, and remaining owner inputs
- docs/DECISIONS.md - stack and security decisions
