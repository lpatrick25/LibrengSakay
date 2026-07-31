# Installation

1. `composer create-project laravel/laravel applicant-portal && cd applicant-portal`
2. Copy package files into the project (merge `routes/web.php`).
3. `php artisan storage:link`
4. `php artisan migrate`
5. `php artisan serve`

- Registration: `/applicant/register`
- Management: `/admin/applicants`

CDN assets (Bootstrap 5, Icons, jQuery, Bootstrap Table, SweetAlert2) are already linked in the layout—no npm build required.
