# URL Shortener

A multi-tenant URL shortening service built with Laravel 12. Companies have multiple users, each user is either an Admin or a Member, and a SuperAdmin manages company onboarding across the whole platform.

## Tech Stack

- **Backend:** PHP 8.2+, Laravel 12, MySQL
- **Frontend:** Blade, Bootstrap 5, jQuery, AJAX
- **Auth:** Laravel Breeze
- **API:** Laravel Sanctum (token auth), REST endpoints under `/api/v1`

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL 8.0+

## Local Setup

1. **Clone the repository**
```bash
   git clone https://github.com/karanpgajjar/url-shortener.git
   cd url-shortener
```

2. **Install PHP dependencies**
```bash
   composer install
```

3. **Configure environment**
```bash
   cp .env.example .env
   php artisan key:generate
```

4. **Update `.env` with your MySQL credentials**
```env
   DB_DATABASE=url_shortener
   DB_USERNAME=root
   DB_PASSWORD=
```

6. **Run migrations and seed the SuperAdmin account**
```bash
   php artisan migrate --seed
```

7. **Serve the application**
```bash
   php artisan serve
```

   Visit `http://localhost:8000`. OR `http://localhost/url-shortener/public`

## Default Login

A SuperAdmin account is created automatically by the seeder:
Email: `superadmin@example.com`
Password: `password`

## REST API

Token-authenticated endpoints under `/api/v1`, using Laravel Sanctum.

Generate a token for testing (no login-to-token endpoint exists yet):
```bash
php artisan tinker
>>> $user = \App\Models\User::where("role", "admin")->first();
>>> $user->createToken("api-test")->plainTextToken;
```