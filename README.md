

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## GUIDA JAVID 

## Step 1: Install Laravel 11
Creazione del progetto Laravel 11


```bash
composer create-project --prefer-dist laravel/laravel:^11.0 INJA_UNJA
```
Explanation: This command uses Composer to create a new Laravel project with version 11. The --prefer-dist option downloads the distribution-ready package, and INJA_UNJA is the name of the project directory.
## Step 2: Install NPM Dependencies
Install basic project dependencies
```bash
npm install
```
Explanation: This command installs all the Node.js dependencies listed in the package.json file. It’s necessary to run this right after creating the project to ensure all the required JavaScript libraries are available.

# Install Vite (Build Tool)
```bash
npm install --save-dev vite
```
Explanation: Vite is a build tool used to compile and bundle frontend resources. In Laravel 11, Vite is the default build tool. Installing it as a development dependency (--save-dev) ensures it's only used in the development environment.
# Install Vue.js

```bash
npm install vue
```
Explanation: This command installs Vue.js, a JavaScript framework used to build dynamic user interfaces.
## Step 3: Install and Configure Inertia.js
Install Inertia.js for Laravel
```bash
composer require inertiajs/inertia-laravel
```
Explanation: Inertia.js provides a way to build Single Page Applications (SPA) without needing a separate API. This command installs the Inertia package for Laravel.
## Install the Inertia.js Vue Client
```bash
install @inertiajs/inertia @inertiajs/inertia-vue3
```
Explanation: This installs the libraries needed to integrate Inertia.js with Vue 3. This step connects the Vue frontend to the Laravel backend through Inertia.js.
## Create the Inertia Middleware
```bash
php artisan inertia:middleware
```
Explanation: This command generates middleware to handle Inertia requests in Laravel. Middleware processes requests between the frontend and backend.
## Step 4: Install Vuetify (UI Framework)
Install Vuetify

```bash
npm install vuetify@next
```
Explanation: Vuetify is a UI component framework built on Vue.js. This command installs Vuetify’s latest version compatible with Vue 3.
##Step 5: State Management with Pinia
Install Pinia

```bash
npm install pinia
```
Explanation: Pinia is a modern state management library for Vue.js, similar to Vuex but more lightweight and easier to use. This command installs Pinia for state management in your project.
## Step 6: Other Useful Commands
Install Composer dependencies
```bash
composer install  
```
Explanation: This command installs the PHP dependencies listed in the composer.json file. It’s useful when you clone a Laravel project from a repository and need to set up everything to run the application.
## Install NPM dependencies (short version)
```bash
nom i
```
Explanation: This is a short form of npm install, which installs the dependencies listed in the package.json file.





