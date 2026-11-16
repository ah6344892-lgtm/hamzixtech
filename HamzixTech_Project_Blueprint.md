# HamzixTech — Complete Project Blueprint
**Document type:** Product Requirements + Technical Architecture + Development Specification  
**Project:** HamzixTech Technology Platform  
**Primary stack:** Laravel + Livewire + Livewire Flux UI + MySQL  
**Development environment:** Windows 10/11, VS Code, Codex  
**Status:** Master specification for implementation

---

## 1. Project Vision

HamzixTech is a modern technology and digital-solutions platform. It is not a Laravel-only portfolio website. It should present a broad, professional technology brand focused on modern websites, custom software, web applications, useful developer resources, templates, tutorials, technology articles, and future AI-powered tools.

The website has two connected purposes:

1. **Brand and service presence:** Explain HamzixTech, showcase capabilities and projects, build trust, and let potential clients contact the business.
2. **Technology resource platform:** Publish blogs, tutorials, reusable templates, practical tools, code resources, and eventually AI-powered utilities.

The platform should be scalable and maintainable. Build it as a real application with a secure management panel, structured database, reusable components, clear authorization, and SEO-friendly public pages.

### Core product principles

- Professional, clean, modern, responsive design.
- Strong typography, clear spacing, consistent components.
- Both light and dark themes.
- Fast page loads and good Core Web Vitals.
- SEO-friendly URLs and server-rendered/indexable public content.
- Secure role-based access control.
- Easy content management without editing source code for routine publishing.
- Reusable architecture; avoid duplicated page-specific implementations.
- Do not fabricate services, client testimonials, statistics, certifications, or project results.
- Do not expose unfinished features as completed products. Mark future/experimental features appropriately.

---

## 2. Technology Stack — Required

Use current stable versions compatible with the installed PHP and Laravel project. Before installing packages, inspect the existing repository, PHP version, Composer constraints, Laravel version, and package compatibility. Do not blindly upgrade or downgrade the project.

### Backend and application

- PHP (version compatible with the chosen Laravel version)
- Laravel
- MySQL
- Eloquent ORM
- Laravel migrations
- Laravel validation, policies, middleware, queues and cache where appropriate
- Laravel filesystem for uploads
- Laravel mail system for contact notifications (configurable)

### Interactive UI

- Livewire for reactive server-driven components and interactions.
- Livewire Flux UI for modern interface components.
- Tailwind CSS as required by the installed Flux/Laravel setup.
- Alpine.js only where a small client-side interaction is useful and not already provided by Livewire/Flux.
- Vite for asset compilation.

**Important terminology:** The intended UI library is **Livewire Flux**, not Python Flask. Do not add Flask to this Laravel application.

### Authentication and authorization

- Laravel authentication using a compatible official starter/authentication approach.
- Spatie Laravel Permission for roles and permissions.
- Use policies/gates for resource-level authorization in addition to menu visibility.
- Never rely only on hiding buttons in the UI.

### Other packages

Evaluate package compatibility before installation. Prefer well-maintained packages and avoid unnecessary dependencies. Possible packages, only where useful:
- Spatie Laravel Permission
- Spatie Laravel Sluggable or an equivalent simple slug strategy (optional)
- A maintained sitemap generator (optional)
- A maintained SEO helper (optional)
- A maintained image optimization solution (optional)

Do not install overlapping packages that duplicate Laravel or Flux functionality.

---

## 3. Brand Identity and Design System

### Logo

The owner will provide the final logo image separately to Codex.

Logo description for implementation guidance only:
- A circular monogram containing the letters **H** and **T**.
- H is pure white.
- T is electric blue.
- A circular ring surrounds the HT monogram.
- No Z letter.
- No extra tagline embedded in the symbol.
- Use the supplied logo asset exactly; do not generate a replacement, redraw it, or invent a different mark.
- Support light and dark variants if the owner supplies them. If only one version is supplied, use a suitable background/container that preserves contrast.
- Do not distort the logo. Keep its aspect ratio.
- Use the logo for navbar, footer, favicon/app icon where appropriate. Create favicon sizes from the supplied asset only if technically possible without altering its identity.

Suggested asset location after owner uploads it:
`public/images/brand/hamzixtech-logo.png`

If the actual filename differs, update the configuration/reference consistently.

### Brand colors

Use a restrained blue-and-white visual identity.

| Token | Value | Usage |
|---|---|---|
| Electric Blue | `#1677F8` | Primary actions, links, active states, T accent |
| Pure White | `#FFFFFF` | White surfaces and H accent |
| Deep Navy | `#071426` | Dark theme background and dark sections |
| Slate Navy | `#17263B` | Dark cards, panels, borders |
| Soft Gray | `#9AA9BD` | Secondary dark-theme text |
| Light Surface | `#F7F9FC` | Light page background |
| Dark Text | `#172033` | Main light-theme text |
| Muted Text | `#64748B` | Secondary light-theme text |
| Border | `#E5EAF1` | Light borders |

Do not add many unrelated accent colors. Electric blue and white should remain the dominant identity. Check text contrast in both themes.

### Theme system

Provide:
- Light theme
- Dark theme
- System preference option if feasible
- Theme toggle visible in the public navbar and management panel
- Persist user preference (local storage/cookie for guests; user preference in database for authenticated users if implemented)
- Avoid flash of the wrong theme on page load.
- All components, forms, dropdowns, tables, modals, cards, charts and editor interfaces must support both themes.
- Theme must be consistent across all routes.

### Typography and visual style

- Use a modern, readable sans-serif font pairing, e.g. Space Grotesk for headings and Inter for body text, if available and performance-appropriate.
- Use consistent font sizes, line heights, spacing and border radii.
- Avoid excessive gradients, glow, glass effects, animations and decorative noise.
- Use subtle transitions only.
- Use a clear visual hierarchy and generous whitespace.
- Keep content readable on small screens.
- Do not make the site look like a generic admin template.

---

## 4. Website Information Architecture

Build the public website with these main sections.

### Primary navigation

- Home
- Services
- Projects
- Blog
- Tutorials
- Templates
- Tools
- About
- Contact

Use a responsive navigation menu on mobile. The logo links to the homepage. Add a clear primary CTA such as “Contact Us” or “Discuss a Project”.

### Public routes (suggested)

Use named Laravel routes and clean, readable URLs.

| Page | Suggested URL |
|---|---|
| Home | `/` |
| Services index | `/services` |
| Service detail | `/services/{slug}` |
| Projects | `/projects` |
| Project detail | `/projects/{slug}` |
| Blog index | `/blog` |
| Blog category | `/blog/category/{slug}` |
| Blog tag | `/blog/tag/{slug}` |
| Blog article | `/blog/{slug}` |
| Tutorials index | `/tutorials` |
| Tutorial detail | `/tutorials/{slug}` |
| Templates index | `/templates` |
| Template detail | `/templates/{slug}` |
| Tools index | `/tools` |
| Tool detail | `/tools/{slug}` |
| About | `/about` |
| Contact | `/contact` |
| Privacy Policy | `/privacy-policy` |
| Terms | `/terms` |
| Cookie Policy (if needed) | `/cookie-policy` |
| Search | `/search?q=...` |
| Sitemap | `/sitemap.xml` |
| Robots | `/robots.txt` |

Use slugs that are unique and stable. If a slug changes, consider a redirect mechanism to avoid breaking indexed URLs.

---

## 5. Homepage Requirements

The homepage should quickly explain what HamzixTech does and guide visitors to useful content or contact.

Recommended sections:

1. **Hero**
   - Clear headline about building modern websites and software solutions.
   - Short supporting paragraph.
   - Primary CTA: Contact / Start a Project.
   - Secondary CTA: Explore Projects or Resources.
   - Supplied HT logo.
2. **What HamzixTech Does**
   - Web development
   - Custom web applications
   - Admin dashboards and business systems
   - Backend/API development
   - UI implementation
   - AI-powered solutions and experiments
3. **Featured Services**
   - Service cards managed through the dashboard.
4. **Featured Projects**
   - Only real projects/demos approved by the owner.
   - Screenshots, description, technologies, demo/source links where available.
5. **Latest Articles**
   - Latest published blog posts.
6. **Featured Templates**
   - Selected templates and their details.
7. **Tools and Resources**
   - Link to useful web tools and developer resources.
8. **Why HamzixTech**
   - Factual, honest value propositions; no fake metrics.
9. **Contact CTA**
   - Invite visitors to discuss a project.
10. **Footer**
   - Navigation, services, social links, contact details, legal pages and copyright.

All homepage sections should be manageable from the admin panel where appropriate. Do not hardcode all featured content into Blade templates.

---

## 6. Services

Create a dynamic services module.

Potential service categories:
- Website Development
- E-commerce Development
- Custom Web Applications
- Admin Dashboards and Management Systems
- Backend Development
- REST API Development
- Database Design
- UI Implementation / Figma to Website
- Responsive Website Development
- AI Integration and AI-powered Features

Each service should support:
- Title
- Slug
- Short description
- Full description (rich text)
- Icon identifier
- Featured image (optional)
- SEO title and description
- Sort order
- Published/draft status
- Featured status
- Created/updated timestamps

Do not claim that every technology or service is already available if it is only planned or experimental. Allow the owner to edit service content.

---

## 7. Projects / Portfolio

Create a project showcase module.

Each project should support:
- Name/title
- Slug
- Short summary
- Full description
- Main image and gallery
- Technologies used
- Project category
- Live demo URL (optional)
- Source code URL (optional)
- Completion date (optional)
- Featured flag
- Sort order
- Status: draft/published/archived
- SEO title/description

Show project detail pages with readable descriptions and screenshots. Never invent client names, testimonials, project metrics or results. The owner can add real projects such as demos and experiments and label them honestly.

---

## 8. Blog Module

The blog is a core feature and must be fully manageable.

### Blog features

- Blog post CRUD.
- Draft, published, scheduled (optional), archived statuses.
- Rich text editor compatible with Livewire.
- Featured image and image alt text.
- Excerpt/summary.
- Main content.
- Slug.
- Author.
- Category.
- Multiple tags.
- SEO title.
- Meta description.
- Canonical URL (optional).
- Open Graph image.
- Reading time (calculated).
- Publish date.
- Featured post flag.
- Related posts.
- Preview before publishing.
- Search, category and tag filtering.
- Pagination.
- Safe handling of rich text and uploaded files.
- Public article page with structured headings and share links.

### Blog categories and tags

Category fields:
- Name
- Slug
- Description
- SEO title/description (optional)

Tag fields:
- Name
- Slug

Prevent duplicate slugs and handle deletion safely. Do not delete a category/tag in a way that silently destroys published content relationships.

---

## 9. Tutorials / Learning Resources

Create a separate Tutorials module (it may share reusable content infrastructure with blogs but should have its own content type and URL).

Tutorial fields:
- Title
- Slug
- Summary
- Content
- Cover image
- Author
- Category
- Tags
- Difficulty: Beginner / Intermediate / Advanced
- Estimated duration (optional)
- Technologies
- Published/draft status
- SEO title/description
- Sort/featured options

Possible tutorial topics include HTML, CSS, JavaScript, PHP, Laravel, Livewire, React, Node.js, Express, MySQL, REST APIs and AI development. Only publish tutorials that have actually been prepared and reviewed.

Optional future capability: tutorial series/lessons with ordering and progress tracking. Do not build a complex learning-management system in the first release unless requested.

---

## 10. Templates Module

Templates are a key platform feature.

### Template listing

Each template card should show:
- Thumbnail
- Name
- Short description
- Category
- Technologies
- Free/Paid label (default free until owner configures payment)
- Demo availability
- Download/source availability

### Template detail

- Full description
- Screenshots/gallery
- Features
- Technology stack
- Requirements
- Installation instructions
- Live demo URL
- GitHub/source URL
- Download link or file
- Version
- Last updated
- License/usage terms
- SEO metadata

### Template management

Admin can:
- Create/edit/delete/archive templates.
- Upload thumbnail and screenshots.
- Add external GitHub repository URL.
- Add demo URL.
- Upload downloadable package if required.
- Set visibility and featured status.
- Manage categories and tags.

For initial releases, templates may be hosted on GitHub and linked from HamzixTech. Do not assume a payment gateway or paid downloads are required. Design the schema so monetization can be added later.

---

## 11. Tools Module

Build a tools directory for useful web and developer utilities.

Requirements:
- Tools index with categories.
- Tool detail page with clean SEO URL.
- Each tool can be enabled/disabled.
- Tool metadata: title, slug, description, icon, category, instructions, SEO title/description.
- Search and filters.
- Responsive interface.
- Track usage only where useful and privacy-respectful.

Possible future tools:
- JSON formatter/validator
- Text utilities
- Slug generator
- URL encoder/decoder
- Color converter
- CSS helpers
- Developer productivity tools

Do not expose a tool in the public menu until it is implemented and tested. Avoid unsafe server-side code execution. Never allow visitors to submit arbitrary code for execution on the application server.

---

## 12. AI Module

Plan an AI section that can grow into multiple AI-powered utilities.

### First release approach

- Create an AI tools landing page.
- Show only tools that are implemented and enabled.
- Build a provider abstraction/service layer so the AI vendor can be changed without rewriting the UI.
- Store API keys in environment variables or secure server-side configuration, never in frontend JavaScript or public database fields.
- Add configurable request limits, validation, timeouts and error handling.
- Add rate limiting and abuse protection.
- Do not log secrets or unnecessarily store users' prompts.
- Clearly disclose when content is AI-generated where appropriate.
- If AI API credentials are not configured, show a professional “currently unavailable / coming soon” state rather than a broken interface.

Potential future AI utilities:
- Writing assistant
- Blog outline helper
- Code explanation helper
- SEO title/meta description assistant
- Text summarizer
- Developer Q&A assistant

Do not build an unrestricted chatbot that can spend API credits without limits. Add usage limits and admin controls before enabling public AI access.

---

## 13. About, Contact and Legal Pages

### About page

Explain:
- What HamzixTech is.
- Its focus on modern websites, software and useful technology resources.
- Its approach to learning, building and sharing.
- Its services and project philosophy.
- A short owner/company introduction that can be edited in the dashboard.

Do not invent company history, team members, office addresses, awards or client numbers.

### Contact page

Include:
- Name
- Email
- Subject
- Message
- Validation and spam protection
- Success/error feedback
- Configurable business email
- Optional project type field
- Optional budget/timeline fields (can be disabled)
- WhatsApp contact link

Store contact submissions securely and allow authorized staff to manage them in the dashboard.

### Privacy Policy

Create an editable legal content page with a clear initial draft structure covering:
- Data collected through forms.
- Purpose of processing.
- Cookies and analytics, if used.
- Third-party services, if used.
- Data retention.
- User contact/request process.
- Security practices.
- Policy update date.

The owner must review the legal text before publication. Do not claim legal compliance certification.

### Terms and Conditions

Create an editable page covering:
- Acceptable use.
- Intellectual property.
- Template license/usage terms.
- External links.
- Service limitations.
- Changes to terms.
- Contact details.

The owner must review the content before publishing.

---

## 14. WhatsApp and Social Media

### Floating WhatsApp button

- Add a floating WhatsApp icon on public pages.
- Keep it visible but unobtrusive.
- Use a configurable phone number with country code.
- Open WhatsApp chat using a safe `wa.me` link.
- Optional prefilled message.
- Position correctly on mobile and desktop.
- Do not invent the phone number. Store it in settings/environment and let the owner configure it.

### Social links

Provide configurable links for:
- Facebook
- LinkedIn
- GitHub
- YouTube (optional)
- Instagram (optional)
- Other platforms (optional)

Show only links that have been configured. Do not render empty or fake social links. Use recognizable small icons with accessible labels.

---

## 15. Admin / Management Panel

The application must have one unified management panel with a consistent layout. Do not create a completely separate dashboard design for every content type.

### URL structure

Suggested:
- Login: `/login`
- Admin dashboard: `/admin`
- Management pages: `/admin/posts`, `/admin/templates`, etc.

Use a common admin layout, sidebar, header, breadcrumbs, theme toggle and reusable tables/forms. Each management resource can have its own URL/page within the same panel.

Examples:
- `/admin/posts`
- `/admin/posts/create`
- `/admin/posts/{post}/edit`
- `/admin/categories`
- `/admin/tags`
- `/admin/tutorials`
- `/admin/templates`
- `/admin/tools`
- `/admin/ai-tools`
- `/admin/services`
- `/admin/projects`
- `/admin/users`
- `/admin/roles`
- `/admin/permissions`
- `/admin/contact-messages`
- `/admin/media`
- `/admin/settings`
- `/admin/activity-logs` (if implemented)

Use route names consistently, e.g. `admin.posts.index`, `admin.posts.create`, `admin.posts.edit`.

### Dashboard overview

Show useful summary cards:
- Total published posts
- Draft posts
- Tutorials
- Templates
- Tools
- Projects
- Unread/new contact messages
- Recent activity

Charts can be added if there is meaningful data. Do not display fabricated numbers or decorative fake analytics.

### Shared management UX

- Search
- Filters
- Pagination
- Sorting where appropriate
- Bulk actions only with authorization and confirmation
- Clear empty states
- Loading states
- Validation messages
- Success/error notifications
- Confirmation before destructive actions
- Responsive tables/cards
- Accessible labels and keyboard navigation

Use Flux UI components consistently. Prefer reusable Livewire components and form patterns.

---

## 16. Roles and Permissions

Use Spatie Laravel Permission. Seed the initial roles and permissions. Enforce authorization server-side using policies/gates and route middleware.

### Roles

#### 1. Super Admin
The owner account.

- Full access to all modules.
- Create, edit, deactivate and manage users.
- Assign roles and permissions.
- Manage system settings.
- Manage all content.
- View contact submissions and activity.
- Manage admin accounts.
- Cannot be accidentally removed/demoted by ordinary admins.
- Protect the last active Super Admin from deletion or demotion.

#### 2. Admin
Trusted administrator, but not equal to Super Admin.

- Manage permitted content modules.
- Manage assigned users if explicitly allowed.
- View dashboard and reports allowed by permissions.
- Cannot manage or remove the Super Admin.
- Cannot grant permissions beyond their own authority.
- Access to settings and role management only if explicitly granted.

#### 3. Manager
Content/operations manager.

- Manage assigned content modules.
- Create, edit, review and publish posts if granted.
- Manage templates, tutorials, projects or services only when permissions allow.
- View and respond to contact messages if granted.
- Cannot manage Super Admin.
- Cannot change system-wide security settings unless explicitly permitted.

#### 4. Employee
Limited staff member.

- Access only assigned modules.
- May create content if granted.
- May edit content if granted.
- May not publish, delete, manage users or change settings unless explicitly granted.
- Do not assume every employee can edit every record. Scope permissions to modules and, where appropriate, ownership/assignment.

### Permission naming convention

Use granular permissions, for example:

- `view dashboard`
- `view posts`
- `create posts`
- `edit posts`
- `delete posts`
- `publish posts`
- `manage post categories`
- `manage post tags`
- `view tutorials`
- `create tutorials`
- `edit tutorials`
- `delete tutorials`
- `publish tutorials`
- `view templates`
- `create templates`
- `edit templates`
- `delete templates`
- `publish templates`
- `manage tools`
- `manage ai tools`
- `manage services`
- `manage projects`
- `view contact messages`
- `reply contact messages`
- `delete contact messages`
- `view users`
- `create users`
- `edit users`
- `deactivate users`
- `manage roles`
- `manage permissions`
- `manage settings`
- `view activity logs`
- `manage media`

Generate permissions systematically for every manageable module. Use exact, consistent permission names.

### Authorization rules

- A role is a convenient permission bundle; permissions are the actual access rules.
- A user can have one or more roles if the implementation requires it, but keep assignment rules clear.
- Only Super Admin can grant Super Admin.
- Admin cannot grant a permission they do not possess.
- Protect critical roles and the last Super Admin.
- Use `can()` checks in UI for visibility, but also enforce policies and middleware on every server action.
- Protect Livewire actions against unauthorized direct requests.
- Validate uploaded files and sanitize rich content.
- Record important security/content actions in an activity log if implemented.

---

## 17. User Management

Admin user management should support:
- Create user.
- Name and email.
- Secure password creation/reset.
- Assign role(s).
- Activate/deactivate.
- Edit profile.
- Optional profile image.
- Last login (if tracked).
- Search/filter.
- Protect Super Admin.
- Do not expose password hashes or sensitive fields.

No public registration is required for staff/admin access. The Super Admin creates staff accounts and assigns roles. If public customer accounts are introduced later, implement them as a separate feature with separate authorization rules.

---

## 18. Database Design

Use MySQL and Laravel migrations. Design normalized tables with appropriate indexes, foreign keys and deletion behavior.

### Core Laravel tables

Use Laravel's standard tables as required:
- `users`
- `password_reset_tokens` or framework equivalent
- `sessions` if database sessions are configured
- `cache`
- `jobs`
- `failed_jobs`
- Spatie permission tables

### Suggested business tables

Implement tables based on actual module scope. Names can be adjusted to match Laravel conventions, but document the final schema.

#### Content

- `posts`
- `categories`
- `tags`
- `post_tag` pivot
- `tutorials`
- `tutorial_categories` or shared category model with type
- `tutorial_tag` pivot if needed
- `templates`
- `template_categories` or shared category model with type
- `template_tag` pivot if needed
- `tools`
- `tool_categories` if needed
- `services`
- `projects`
- `project_technology` pivot or structured JSON only if appropriate

#### Contact and settings

- `contact_messages`
- `site_settings` (or a safe key/value settings structure)
- `social_links` (optional; can be settings)
- `media` only if a media library is genuinely needed

#### Optional operations

- `activity_log` using a maintained package or a simple custom table.
- `redirects` for old slug to new slug mapping.
- `ai_usage_logs` only if usage accounting is required; never store API secrets or unnecessary prompt data.

### Database design rules

- Use foreign keys.
- Add indexes to slugs, status, published dates, category relationships and common search/filter columns.
- Unique constraints for public slugs where appropriate.
- Use nullable columns intentionally.
- Use `softDeletes()` for content where recovery is useful; do not soft-delete every table by default.
- Use pivot tables for many-to-many relationships.
- Use enums or validated strings consistently; choose the approach that fits maintainability.
- Use decimal types for money if payment features are added later.
- Never store uploaded file bytes directly in MySQL unless there is a strong reason; store file paths and metadata.
- Add `created_by` / `updated_by` where auditability is useful.
- Define deletion behavior explicitly.
- Use transactions for multi-table operations.

---

## 19. Migrations, Models, Factories and Seeders

This is a mandatory project requirement.

### Migrations

Every application table must have a migration. Include:
- Correct data types.
- Foreign keys.
- Indexes.
- Unique constraints.
- Pivot tables.
- Nullable/default rules.
- Rollback support.

Do not manually create production tables outside migrations.

### Models

Create Eloquent models for each domain entity. Include:
- `$fillable` or guarded strategy.
- Casts.
- Relationships.
- Scopes for published/active/featured records.
- Slug logic where appropriate.
- Soft delete support where required.
- Authorization policies where relevant.

### Factories

Create a factory for every model that needs test/demo data. At minimum, provide factories for:
- User
- Post
- Category
- Tag
- Tutorial
- Template
- Tool
- Service
- Project
- ContactMessage

Also create factories for additional persisted domain models as appropriate. Factories should generate realistic, valid, internally consistent data and relationship states.

### Seeders

Create seeders for:
- Roles and permissions.
- Initial Super Admin (credentials must come from environment/config or an interactive setup process; never commit a real password).
- Optional demo Admin/Manager/Employee accounts only in local/testing environments.
- Categories and tags.
- Sample posts/tutorials/templates/tools/services/projects only in local/testing/demo environments.
- Default site settings.
- Default social-link records only if they are disabled/empty placeholders, not fake active links.

### Seeder safety

- `DatabaseSeeder` must call seeders in dependency-safe order.
- Seeders must be idempotent using `firstOrCreate`, `updateOrCreate` or equivalent.
- Do not overwrite an existing Super Admin password on every seed.
- Do not insert demo content into production by default.
- Use environment checks to prevent demo seeding in production.
- Document the exact setup command sequence.

### Test data

Use factories in automated tests. Tests should not depend on a developer's personal database records.

---

## 20. Search and Discovery

Implement useful search across public content:
- Posts
- Tutorials
- Templates
- Tools
- Projects (optional)

Requirements:
- Search input in public header.
- Search results page.
- Filters by type/category where useful.
- Pagination.
- Safe query handling.
- No SQL string concatenation with raw user input.
- Useful empty state and clear filters.

A full-text search engine is not required in the first version. Start with indexed MySQL search and design for future upgrades.

---

## 21. SEO Requirements

SEO is a major requirement, not a later decoration.

### Technical SEO

- Server-render public content so search engines can index it.
- Unique title and meta description per public page.
- Canonical URLs.
- XML sitemap with published pages only.
- Correct robots.txt.
- Clean, readable slugs.
- Proper 404 page.
- Redirect old slugs when changed, where possible.
- Open Graph and social preview metadata.
- Twitter/X card metadata where useful.
- Structured data (JSON-LD) where appropriate: Organization, WebSite, Article, BreadcrumbList, SoftwareApplication only when accurate.
- Breadcrumbs on deep pages.
- Semantic HTML.
- Descriptive image alt text.
- Optimized images and responsive sizes.
- Avoid duplicate indexable filter URLs.
- Noindex private/admin/login pages and low-value internal pages.
- Avoid thin/duplicate content.
- Good mobile performance and Core Web Vitals.

### Content SEO

- Admin-editable SEO title and description for posts, tutorials, templates, services and projects.
- Heading hierarchy.
- Internal links to relevant services/resources.
- Image alt text.
- Category/tag pages should provide useful content, not just empty lists.
- Do not keyword-stuff.
- Do not promise Google ranking or guaranteed traffic.

### SEO dashboard

A simple SEO checklist/preview in content forms is useful:
- SEO title length indicator.
- Meta description length indicator.
- Slug field.
- Featured image alt text.
- Preview of search snippet.

Do not build an overly complex SEO scoring system in the first release.

---

## 22. Media and Upload Management

Provide safe upload handling for:
- Logo (owner-supplied)
- Blog featured images
- Tutorial covers
- Template thumbnails/screenshots/packages
- Project images
- Optional profile images

Rules:
- Validate MIME type and file extension.
- Enforce file-size limits from configuration.
- Generate safe unique filenames.
- Store files using Laravel Storage.
- Avoid executable uploads.
- Use image optimization/resizing where practical.
- Provide alt text for public images.
- Use private storage for non-public files.
- Protect download links if a template is not public.
- Never trust the original filename or client MIME header alone.

---

## 23. Notifications and Contact Workflow

Contact message workflow:
- Visitor submits form.
- Validate and protect against spam.
- Save message.
- Show success confirmation.
- Notify configured admin email if mail is configured.
- Display message in admin panel.
- Allow authorized staff to mark as new/read/replied/closed.
- Optional internal notes.
- Do not expose messages publicly.

Use queued email if queues are configured. Ensure the site still handles submissions if email is temporarily unavailable.

---

## 24. Security Requirements

Security is mandatory.

- Use Laravel CSRF protection.
- Validate every request and Livewire action.
- Use authorization policies/gates and role middleware.
- Rate-limit login, contact and AI endpoints.
- Use secure password hashing.
- Use secure session and cookie settings in production.
- Protect against mass assignment.
- Escape output by default.
- Sanitize allowed rich-text HTML.
- Prevent stored/reflected XSS.
- Use parameterized Eloquent queries.
- Validate uploads.
- Keep `.env` out of Git.
- Never expose API keys or database credentials.
- Use HTTPS in production.
- Set correct production debug settings (`APP_DEBUG=false`).
- Keep dependencies updated.
- Add authorization tests for every role.
- Protect the last Super Admin account.
- Do not allow staff to escalate their own permissions.
- Do not trust frontend permission checks.
- Add backups and document restore steps before production launch.

---

## 25. Performance and Accessibility

### Performance

- Use eager loading to prevent N+1 queries.
- Paginate long lists.
- Cache suitable public data.
- Optimize images.
- Avoid loading unused JavaScript.
- Use queues for slow email or background jobs where needed.
- Avoid unnecessary Livewire polling.
- Keep components small and focused.
- Use database indexes based on actual query patterns.

### Accessibility

- Semantic headings and landmarks.
- Keyboard-accessible navigation and dialogs.
- Visible focus states.
- Labels for all form inputs.
- Accessible validation messages.
- Sufficient contrast in light and dark themes.
- Alt text for meaningful images.
- Do not communicate status using color alone.
- Respect reduced-motion preference.

---

## 26. Testing Requirements

Create automated tests with PHPUnit or Pest depending on the existing project setup. Do not mix frameworks unnecessarily.

Minimum test coverage:
- Public homepage and public routes load.
- Published content is visible.
- Draft content is not publicly accessible.
- Slug uniqueness.
- Search and pagination.
- Contact form validation and persistence.
- Authentication.
- Super Admin access.
- Admin restrictions.
- Manager permissions.
- Employee restrictions.
- Direct URL access is blocked without permission.
- Livewire actions are authorized.
- User cannot grant themselves higher permissions.
- Last Super Admin cannot be deleted/demoted.
- Template download access rules.
- Upload validation.
- Theme preference behavior where testable.
- AI endpoint rate limiting and missing-key behavior.

Use factories and seeders in tests. Do not rely on production data.

---

## 27. Recommended Build Phases

Codex should implement in small, verifiable phases. Do not generate the entire application in one uncontrolled pass.

### Phase 0 — Repository inspection

1. Inspect the current Laravel repository.
2. Check PHP, Composer, Laravel, Node and npm versions.
3. Inspect existing migrations, routes, layouts, installed packages and Git status.
4. Identify existing code that must be preserved.
5. Report compatibility issues before changing dependencies.
6. Create or update project documentation.

### Phase 1 — Foundation

- Install/configure compatible Livewire and Flux.
- Configure Tailwind/Vite.
- Configure MySQL.
- Configure authentication.
- Configure Spatie Permission.
- Create base layouts and theme system.
- Add logo asset after owner supplies it.
- Add shared UI components.

### Phase 2 — Database and authorization

- Design and implement migrations.
- Create models and relationships.
- Create policies.
- Create permissions and roles seeder.
- Create factories and safe seeders.
- Create Super Admin setup process.
- Add authorization tests.

### Phase 3 — Public website

- Navbar and footer.
- Homepage.
- Services.
- Projects.
- About.
- Contact.
- Legal pages.
- WhatsApp and configurable social links.
- Responsive and theme support.

### Phase 4 — Content modules

- Blog CRUD and public pages.
- Categories and tags.
- Tutorials.
- Templates.
- Tools.
- Search and filtering.
- SEO metadata.

### Phase 5 — Admin panel

- Unified `/admin` layout.
- Dashboard overview.
- CRUD pages.
- Media uploads.
- User management.
- Role/permission management.
- Contact message management.
- Settings.
- Activity log if included.

### Phase 6 — AI foundation

- AI tools directory.
- Provider abstraction.
- Secure environment configuration.
- Rate limits and usage controls.
- First AI utility only after API provider and feature scope are decided.
- Graceful unavailable state when no API key exists.

### Phase 7 — SEO, quality and launch readiness

- Sitemap and robots.
- Structured data.
- Metadata validation.
- Accessibility review.
- Performance review.
- Security review.
- Full automated tests.
- Production deployment documentation.
- Backup and restore documentation.

---

## 28. Suggested Project Structure

Follow Laravel conventions. Keep code organized by responsibility. Example structure (adapt to the installed Laravel version):

```text
app/
  Livewire/
    Public/
    Admin/
      Dashboard/
      Posts/
      Categories/
      Tags/
      Tutorials/
      Templates/
      Tools/
      Services/
      Projects/
      Users/
      Roles/
      ContactMessages/
      Settings/
  Models/
  Policies/
  Services/
    AI/
    SEO/
    Media/
  Actions/                 # only if useful
  Support/
database/
  factories/
  migrations/
  seeders/
resources/
  views/
    layouts/
    components/
    livewire/
      public/
      admin/
  css/
  js/
routes/
  web.php
  auth.php                 # if used by the auth package
tests/
  Feature/
  Unit/
public/
  images/
    brand/
```

Do not create unnecessary layers or folders just to match this example. Prefer clear, conventional Laravel code.

---

## 29. Admin UI Layout and Interaction

### Sidebar groups

Suggested groups:
- Overview
- Content
  - Posts
  - Categories
  - Tags
  - Tutorials
- Resources
  - Templates
  - Tools
- Business
  - Services
  - Projects
  - Contact Messages
- AI
  - AI Tools
  - Usage (only if implemented)
- Administration
  - Users
  - Roles
  - Permissions
  - Activity Log
  - Settings

Show only links the logged-in user is authorized to access.

### Forms

- Use reusable form components.
- Validate on server.
- Show field-level validation.
- Use safe rich text editor.
- Provide save draft and publish actions where appropriate.
- Confirm destructive operations.
- Preserve entered data after validation errors.
- Use clear loading/disabled states.

### Tables

- Search and filters.
- Pagination.
- Status labels.
- Created/updated date.
- Row actions based on permissions.
- Bulk selection only if properly authorized.
- Responsive alternative layout on mobile.

---

## 30. Configuration and Environment Variables

Use `.env.example` with placeholders only. Never commit secrets.

Expected configuration may include:

```dotenv
APP_NAME=HamzixTech
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hamzixtech
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log

HAMZIXTECH_WHATSAPP_NUMBER=
HAMZIXTECH_CONTACT_EMAIL=

AI_PROVIDER=
AI_API_KEY=
AI_MODEL=
```

Use Laravel config files to read environment variables. Do not call `env()` directly throughout application code.

For production, set secure values, `APP_DEBUG=false`, HTTPS URL, real database credentials, mail configuration and AI credentials only if AI is enabled.

---

## 31. Initial Setup and Developer Documentation

Codex must create/update a `README.md` with exact commands for the actual installed versions. A typical workflow may look like:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Then configure MySQL database credentials in `.env`, followed by:

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

During frontend development:

```bash
npm run dev
```

Commands must be checked against the installed Laravel version and authentication setup. On Windows PowerShell, if `npm.ps1` execution policy blocks npm, use the appropriate `npm.cmd` command or the user's configured terminal. Do not change system execution policy without explaining why and obtaining approval.

Document:
- PHP and Composer requirements.
- Node requirements.
- MySQL setup.
- Environment configuration.
- Super Admin creation.
- Storage link.
- Queue setup if used.
- Mail setup.
- AI setup.
- Production build/deployment.
- Backup/restore.

---

## 32. Deployment Readiness

Prepare the application for deployment to a Laravel-compatible host.

- Confirm PHP extensions required by Laravel and packages.
- Configure document root to Laravel `public/`.
- Never expose `.env`, storage internals or source files publicly.
- Run migrations safely.
- Build frontend assets.
- Set correct file permissions.
- Configure HTTPS.
- Configure queue worker/cron if needed.
- Configure cache and session drivers.
- Configure backups.
- Disable debug.
- Test file uploads and mail.
- Test admin authorization on production.
- Keep secrets out of Git.

If initial hosting has limited PHP/database/background-worker support, inspect host limitations before selecting deployment architecture. Do not assume a static-hosting service can run Laravel.

---

## 33. Out of Scope for the First Release

Do not add these without a separate decision:
- Public user registration/community accounts.
- Complex multi-vendor marketplace.
- Payment gateway and paid subscriptions.
- Full LMS with course enrollment/progress.
- Arbitrary user code execution.
- Unlimited public AI usage.
- Native mobile application.
- Multi-tenant SaaS architecture.
- Complex CRM/ERP features.

Keep the architecture extensible, but do not over-engineer the first release.

---

## 34. Definition of Done

The first release is not complete until:

- Public website pages work on desktop, tablet and mobile.
- Light and dark themes work consistently.
- Supplied HT logo is used without redesign.
- MySQL schema is created through migrations.
- Models and relationships are correct.
- Required factories and seeders exist.
- Seeders are safe and idempotent.
- Super Admin can manage the platform.
- Admin/Manager/Employee access follows permissions.
- Unauthorized direct URLs and Livewire actions are blocked.
- Blog, tutorial, template, tools, services and projects modules work.
- Draft content is hidden from public visitors.
- Contact form works and messages can be managed.
- WhatsApp and social links are configurable.
- SEO metadata, sitemap and robots are implemented.
- Uploads are validated and secure.
- Automated tests pass.
- README contains setup and deployment steps.
- No fake content, credentials, links, testimonials or statistics remain.
- No unfinished module is presented as fully functional.

---

## 35. Instructions to Codex — How to Work

1. Read this entire document before editing code.
2. Inspect the existing repository and report the current state.
3. Do not delete or overwrite existing working code without explaining the impact.
4. Do not assume package versions. Verify compatibility first.
5. Use Laravel + Livewire + Livewire Flux UI + MySQL. Do not use Flask.
6. Use the owner's supplied HT logo. Do not generate another logo.
7. Follow the blue/white brand system and implement both light and dark themes.
8. Implement one phase at a time.
9. After each phase:
   - summarize files created/changed;
   - list commands run;
   - report migrations/tests/build status;
   - identify unresolved issues;
   - wait for review before risky architectural changes.
10. Do not claim a feature is complete unless it is implemented and tested.
11. Do not create fake social URLs, contact details, API keys, client testimonials or metrics.
12. Do not put all logic in controllers or giant Livewire components. Keep components focused and reusable.
13. Use policies and server-side permission checks for every protected action.
14. Use factories and seeders for all appropriate domain models.
15. Keep the code readable and maintainable. Prefer straightforward Laravel conventions over unnecessary abstraction.
16. If a requirement is ambiguous, inspect this specification and the repository first. Ask only when a real product/security decision cannot be safely inferred.
17. Maintain a `docs/IMPLEMENTATION_STATUS.md` checklist showing completed, in-progress and pending phases.
18. Keep a `docs/DECISIONS.md` file for important technical decisions and package/version choices.
19. At the end of each phase, run relevant automated tests and frontend build checks.
20. Prioritize a reliable, secure, working application over visual effects or generating large amounts of untested code.

---

## 36. Owner-Provided Values Still Needed

Do not invent these values. Keep them configurable and leave placeholders until supplied:

- Final HT logo file.
- Domain name and production URL.
- Official contact email.
- WhatsApp phone number (with country code).
- Social profile URLs.
- About-page owner/company wording.
- Real project portfolio details and screenshots.
- AI provider, model and API key.
- Production hosting/database credentials.
- Any template license wording that differs from the default.

---

**End of HamzixTech Project Blueprint**
