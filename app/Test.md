## TEST

prima di tutto per fare test devo fare n .env.testing
che si è copiato .env e solo che sia una nuova db in questo tipo

[DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=InjaUnja_testing
DB_USERNAME=root
DB_PASSWORD=
]()

per configurare laravel sanctum
```bash
composer require laravel/sanctum
```
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

