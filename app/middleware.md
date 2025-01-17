

php artisan inertia:middleware

->withMiddleware(function (Middleware $middleware) {
$middleware->web(append: [\App\Http\Middleware\HandleInertiaRequests::class]);
})
ora ho creato responce 

ora posso creare route con Inertia 

i tailwind.config.js

content: [
'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
'./storage/framework/views/*.php',
'./resources/**/*.blade.php',
'./resources/**/*.js',
'./resources/**/*.vue',
],



in app.css

@tailwind base;
@tailwind components;
@tailwind utilities;

** return inertia( 'About',['user'=>'javid]) --> injoori mitooni ettelaateto bedi bere be .vue
Route::Inetia('/about','About',['user'=>'javid'])


 dopo di creazione front

php artisan make:controller AuthController



