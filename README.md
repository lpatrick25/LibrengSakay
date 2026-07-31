# Laravel 12 Applicant Registration & Management System

A modern, elegant, production-ready Applicant Registration portal and Management Dashboard built with Laravel 12, Bootstrap 5, jQuery AJAX, Bootstrap Table, and SweetAlert2.

Designed to resemble a government / higher-education online application portal.

## Features

### Public Registration
- Multi-step registration (Category Selection → Registration Form)
- Three applicant categories with dynamic ID upload requirements
- AJAX form submission (no page reloads)
- Laravel Form Request validation with JSON responses
- File upload (JPG, JPEG, PNG, PDF) with preview
- Data Privacy consent (RA 10173)
- Skeleton/shimmer loading effects

### Admin Management Dashboard
- Statistics cards (Total, by category, today, pending, verified)
- Wenzhixin Bootstrap Table with **server-side** pagination, sorting, search
- Advanced filters (category, verification status, ID status, date range, place)
- View modal with ID preview
- Verify / Reject (with remarks) / Delete actions
- Download uploaded ID
- Export (CSV, Excel, PDF) & Print
- Sticky header, column toggle, responsive design

## Quick Start

```bash
composer create-project laravel/laravel applicant-portal
cd applicant-portal

# Copy all files from this package into the project root

php artisan storage:link
php artisan migrate
php artisan serve
```

- **Registration:** http://127.0.0.1:8000/applicant/register  
- **Management:**  http://127.0.0.1:8000/admin/applicants  

## Routes

| Method | URI | Name |
|--------|-----|------|
| GET | `/applicant/register` | `applicant.register` |
| POST | `/applicant/register` | `applicant.register.store` |
| GET | `/admin/applicants` | `admin.applicants.index` |
| GET | `/admin/applicants/statistics` | `admin.applicants.statistics` |
| GET | `/admin/applicants/data` | `admin.applicants.data` |
| GET | `/admin/applicants/{id}` | `admin.applicants.show` |
| POST | `/admin/applicants/{id}/verify` | `admin.applicants.verify` |
| POST | `/admin/applicants/{id}/reject` | `admin.applicants.reject` |
| DELETE | `/admin/applicants/{id}` | `admin.applicants.destroy` |
| GET | `/admin/applicants/{id}/download-id` | `admin.applicants.download-id` |

## Applicant Types

| Value | Label |
|-------|-------|
| `abuyognon` | Abuyognon |
| `acc_student` | ACC Student |
| `non_abuyognon` | Non-Abuyognon |

## Verification Statuses

`pending` · `verified` · `rejected`

## ID Statuses

`uploaded` · `missing` · `needs_review`

## Optional `.env`

```env
APP_MAX_UPLOAD_KB=5120
```

## License

MIT
