# Installation

1. `composer create-project laravel/laravel applicant-portal && cd applicant-portal`
2. Copy all package files into the project (merge carefully).
3. `php artisan storage:link && php artisan migrate`
4. Create a user:
   ```bash
   php artisan tinker
   >>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('password')]);
   ```
5. `php artisan serve`

- Login: `/login`
- Registration: `/applicant/register`
- Applicants: `/admin/applicants` (requires login)
- Users: `/admin/users` (requires login)
