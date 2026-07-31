# Laravel 12 Applicant Portal

Modules: Registration · Applicant Management · User Management · Authentication · Email Templates

## URLs

| Module | Path | Access |
|--------|------|--------|
| Login | `/login` | Guest |
| Registration | `/applicant/register` | Public |
| Applicants | `/admin/applicants` | Auth |
| Users | `/admin/users` | Auth |
| Email Templates | `/admin/email-templates` | Auth |

## Email Templates

- Two protected templates: `applicant_approved`, `applicant_rejected` (cannot be deleted)
- CKEditor 5 rich body editor
- Placeholder variables with one-click copy
- Live preview with sample data
- Send test email
- Enable / disable toggle
- Centralized `EmailTemplateRenderer` service + `TemplatedMail` mailable

### Seed templates

```bash
php artisan db:seed --class=EmailTemplateSeeder
```

Or add to `DatabaseSeeder`.

### Sending real approval/rejection emails

```php
use App\Services\EmailTemplateRenderer;
use App\Mail\TemplatedMail;
use Illuminate\Support\Facades\Mail;

$renderer = app(EmailTemplateRenderer::class);
$rendered = $renderer->renderForApplicant('applicant_approved', $applicant);

if ($rendered) {
    Mail::to($applicant->email)->send(
        new TemplatedMail($rendered['subject'], $rendered['body'])
    );
}
```

## Install

```bash
composer create-project laravel/laravel applicant-portal
cd applicant-portal
# copy package files
php artisan storage:link
php artisan migrate
php artisan db:seed --class=EmailTemplateSeeder
php artisan tinker
>>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('password')]);
php artisan serve
```

Configure mail in `.env` for test emails (`MAIL_MAILER`, etc.).

## License

MIT
