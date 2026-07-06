# Backend

Backend Ouvvee Toys adalah Laravel app di folder ini.

Laravel menjalankan backend OOP dan Blade view dalam satu project. UI Blade tetap berada di `resources/views` karena itu cara Laravel server-rendered app bekerja.

## Struktur Backend OOP

| Area | Lokasi |
| --- | --- |
| Routes web | `routes/web.php` |
| Controllers | `app/Http/Controllers/` |
| Models / entity ORM | `app/Models/` |
| Auth gate | `app/Providers/AppServiceProvider.php` |
| Database schema | `database/migrations/` |
| Seed data referensi | `database/seeders/` |
| Blade views | `resources/views/` |
| Public assets | `public/` |
| Feature tests | `tests/Feature/` |

## Run

```powershell
cd backend
.\.runtime\php-src\php.exe artisan serve
```

## Test

```powershell
cd backend
.\.runtime\php-src\php.exe .\vendor\bin\phpunit
```
