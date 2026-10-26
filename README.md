# Smart Internship Management System — Laravel Starter

Laravel 11/12 · PHP 8.2+ · MySQL/SQLite · Sanctum (API for Android/Web JS)

## 1. Install

```bash
composer create-project laravel/laravel smart-internship
cd smart-internship
php artisan install:api          # installs Sanctum + routes/api.php
```

Copy everything from this overlay folder into the project (overwrite when asked):
`app/`, `bootstrap/app.php`, `database/`, `resources/`, `routes/`

## 2. Configure `.env`

```
DB_CONNECTION=mysql
DB_DATABASE=smart_internship
DB_USERNAME=root
DB_PASSWORD=
```
(or keep `DB_CONNECTION=sqlite` for quick testing)

## 3. Run

```bash
php artisan migrate --seed
php artisan storage:link         # for CV / report uploads
php artisan serve
```

## 4. Demo accounts (password: `password`)

| Role | Email |
|---|---|
| Admin | admin@example.com |
| Supervisor | supervisor@example.com |
| Intern | intern@example.com |
| Pending Intern | pending@example.com (cannot login until approved) |

Web (Admin): http://127.0.0.1:8000/login

## 5. REST API (Bearer token, for Android Studio / JS)

`POST /api/login` → `{ token, user }` then send `Authorization: Bearer <token>`

| Method | Endpoint | Role |
|---|---|---|
| POST | /api/register | public (status = pending) |
| POST | /api/login | public |
| POST | /api/logout, GET /api/me | all |
| PUT | /api/profile, POST /api/profile/cv | all |
| GET | /api/programs?q=&status= | all (intern sees open only) |
| POST/PUT/DELETE | /api/programs | supervisor, admin |
| POST | /api/applications | intern |
| GET | /api/applications | all (scoped by role) |
| PATCH | /api/applications/{id}/review | supervisor, admin |
| GET/POST | /api/attendance | GET all · POST supervisor/admin |
| GET | /api/reports | all (intern sees own) |
| POST | /api/reports | intern |
| PATCH | /api/reports/{id}/review | supervisor, admin |
| GET/POST | /api/evaluations | GET all · POST supervisor/admin |
| GET/POST | /api/messages/{user}, /api/messages | all |
| GET | /api/notifications, PATCH /api/notifications/{id}/read | all |
| GET | /api/admin/dashboard | admin |
| CRUD | /api/admin/users, /api/admin/companies | admin |
| GET/PATCH | /api/admin/registrations, .../{id}/approve, .../{id}/reject | admin |
| POST | /api/admin/notifications | admin |

### Android (Retrofit) example
```kotlin
@POST("login") suspend fun login(@Body body: LoginBody): LoginResponse
@GET("programs") suspend fun programs(@Header("Authorization") bearer: String): ProgramPage
```
Android emulator base URL: `http://10.0.2.2:8000/api/`

## 6. Notes
- Primary keys use Laravel default `id`; foreign keys follow `{entity}_id` (`intern_id`, `program_id` ...).
- Registration flow: register → `pending` → Admin approves → can login.
- Web pages exist for Admin. Supervisor/Intern use the API (mobile) — add Blade pages following `AdminController` + views as a template.
- Validate everything in production (rate limiting, policies, file scanning). This is a learning starter.
