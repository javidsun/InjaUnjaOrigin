<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


$files = glob(__DIR__ . '/frontend/*.php');
foreach ($files as $file) {
    require $file;
}

Route::group(['middleware' => 'auth:sanctum'], function () {

});
Route::get('/add-property', function () {
    return Inertia::render('AddProperty');
});

Route::get('/gift-card', function () {
    return Inertia::render('GiftCard');
});

Route::get('/inja-unja', function () {
    return Inertia::render('InjaUnja');
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});
Route::get('', function () {
    return Inertia::render('Welcome');
});
Route::get('/', function () {
    return Inertia::render('Home2');
});
Route::get('/register', function () {
    return Inertia::render('RegisterUser');
});
Route::get('/home', function () {
    return Inertia::render('Home');
});
Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');

Route::get('/twoStep', function () {
    return Inertia::render('layout/menu_component/two-steps');
});

Route::get('/reset-password', function () {
    return Inertia::render('layout/menu_component/reset-password');
});

Route::get('/verify-email', function () {
    return Inertia::render('layout/menu_component/verify-email');
});


Route::get('/add-property', function () {
    return Inertia::render('AddProperty');
});

Route::get('/gift-card', function () {
    return Inertia::render('GiftCard');
});

Route::get('/inja-unja', function () {
    return Inertia::render('InjaUnja');
});

Route::get('/help-center', function () {
    return Inertia::render('HelpCenter');
});
Route::get('/AdminDashboard', function () {
    return Inertia::render('views/dashboards/Admin/AdminDashboard');
});

Route::get('/UserDashboard', function () {
    return Inertia::render('Users/UserDashboard/UserDashboard');
});
Route::get('/UserProfile', function () {
    return Inertia::render('Users/UserDashboard/UserProfile');
});

    Route::get('/UserReservations', function () {
        return Inertia::render('Users/UserDashboard/UserReservations');
    })->name('UserReservations');

    Route::get('/MyAds', function () {
        return Inertia::render('Users/UserDashboard/MyAds');
    })->name('MyAds');

    Route::get('/notifications', function () {
        return Inertia::render('Users/UserDashboard/Notifications');
    })->name('notifications');

    Route::get('/UserFinance', function () {
        return Inertia::render('Users/UserDashboard/UserFinance');
    })->name('UserFinance');

    Route::get('/UserSettings', function () {
        return Inertia::render('Users/UserDashboard/UserSettings');
    })->name('UserSettings');

    Route::get('/Support', function () {
        return Inertia::render('Users/UserDashboard/Support');
    })->name('Support');


// Routes for public sections
Route::get('/houses', function () {
    return Inertia::render('Houses');
})->name('houses');

Route::get('/vehicles', function () {
    return Inertia::render('Vehicles');
})->name('vehicles');

Route::get('/events', function () {
    return Inertia::render('Events');
})->name('events');

Route::get('/travelers', function () {
    return Inertia::render('Travelers');
})->name('travelers');
