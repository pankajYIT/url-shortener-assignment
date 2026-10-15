# URL Shortener Assignment

A small company-aware URL shortener built for Laravel 12, PHP 8.2+, and SQLite. It includes login/logout, role-based access, user creation/invitation restrictions, authenticated short-link redirects, and feature tests.

## Important assignment interpretations

- Only `Sales` and `Manager` may create short URLs because the brief explicitly prohibits `SuperAdmin`, `Admin`, and `Member` from creating them.
- Admin URL lists exclude URLs created inside the Admin's own company.
- Member URL lists exclude URLs created by that Member.
- Short links are not public: `/s/{code}` requires login and then checks access before redirecting. A link is not a public redirect service.
- The brief does not define Sales/Manager list permissions. This implementation limits them to their own company.
- The SuperAdmin invitation rule is interpreted as: SuperAdmin cannot create an Admin user assigned to a company. Admin cannot create Admin or Member users in their own company.

## Requirements

- PHP 8.2+
- Composer 2
- SQLite PHP extension (or switch `.env` to MySQL)

## Local setup

```bash
git clone <your-public-repository-url>
cd url-shortener-assignment
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Open http://127.0.0.1:8000/login.

Seeded SuperAdmin credentials:

- Email: `superadmin@example.com`
- Password: `ChangeMe123!`

Change this password before deploying anywhere. The seeder creates the SuperAdmin using a raw SQL `INSERT` statement as requested.

## Run tests

```bash
php artisan test
```

## Roles and demo data

The seeder creates only the SuperAdmin and the Platform company. To test company-specific flows, create companies and users through a local tinker session or add demo seed data. Sales/Manager accounts must have a `company_id` to create URLs.

## GitHub submission

Create a public repository on GitHub, then run:

```bash
git init
git add .
git commit -m "Implement company-aware URL shortener assignment"
git branch -M main
git remote add origin https://github.com/<your-username>/<repository-name>.git
git push -u origin main
```

Do not commit `.env` or real credentials. Share the public GitHub repository URL after pushing.

## Scope / production notes

This is an assignment starter, not a production-ready service. User creation currently assigns a random password and does not send an invitation email or password-reset link. Add Laravel's password reset / notification workflow if the evaluator expects invitation acceptance. Consider rate limiting, audit logs, and stricter company lifecycle management before production use.
