# HamzixTech Decisions

Last updated: 2026-11-16 (Asia/Karachi)

## Product direction

- The owner directed full website development in the main workspace, D:\coding\hamzixtech, without stopping at approval gates between blueprint phases.
- The original HamzixTech_Project_Blueprint.md and both project documents are preserved.
- Stack: PHP 8.2, Laravel 12, MySQL, Livewire 4, Livewire Flux UI 2, Tailwind CSS 4, Vite 6, Fortify, and Spatie Laravel Permission.
- The supplied logo is used at public/images/brand/hamzixtech-logo.png without editing the source image.
- Use the electric blue, white, navy, and slate palette; public and admin pages support system, light, and dark appearance.
- Do not invent contact details, social URLs, portfolio work, testimonials, statistics, credentials, or owner-specific legal statements.

## Compatibility and installed versions

The installed versions were selected and verified for the existing PHP 8.2.12 runtime. PHP was not upgraded.

- PHP CLI 8.2.12
- Laravel Framework 12.72.0
- Livewire 4.4.8
- Livewire Flux UI 2.21.0
- Tailwind CSS 4.3.5
- Vite 6.4.6
- Laravel Fortify 1.42.0
- Spatie Laravel Permission 6.25.0
- Composer 2.11.1
- Node.js 26.13.0 and npm 11.20.0

## Application and security decisions

- MySQL is the configured application database. Test runs use an isolated in-memory SQLite database.
- Laravel Fortify handles staff login and password resets. Public registration is disabled.
- Roles and permissions are enforced server-side through middleware, policies, and controller checks. Super Admin capabilities come from seeded permissions; there is no blanket authorization bypass.
- The built-in roles are Super Admin, Admin, Manager, and Employee. Seeders create permissions and safe starter settings without demo accounts or resetting passwords.
- The interactive hamzixtech:super-admin command creates or grants the Super Admin role without exposing credentials in source files.
- Markdown is rendered through a sanitizing path. Uploads use validated file types and generated names; template packages are stored privately and downloads are checked before delivery.
- Contact messages are validated, protected with a honeypot and rate limit, stored privately, and optionally emailed when configured.
- AI provider integration uses a server-side provider abstraction. No provider is registered, so AI tools remain unavailable until a supported provider is implemented and configured.
- Never use migrate:fresh against the configured database. Use migrations and the idempotent seeder.

## Owner values still needed

The application leaves these configurable rather than making them up: production domain, official contact email, WhatsApp number and message, social URLs, real portfolio projects and images, approved homepage/about wording, final legal review, template-specific licenses, production mail/database/hosting settings, and an AI provider/model/credential.
