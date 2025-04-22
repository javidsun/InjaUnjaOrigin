### Auth User

#### login

prima di tutto installiamo socialite

```bash
composer require laravel/socialite
```
vengono installati

inertiajs/inertia-laravel

laravel/pail ................................................................................................................................ 
laravel/sail ................................................................................................................................ 
laravel/sanctum ............................................................................................................................. 
laravel/socialite ........................................................................................................................... 
laravel/tinker .............................................................................................................................. 
nesbot/carbon ............................................................................................................................... 
nunomaduro/collision ........................................................................................................................ 
nunomaduro/termwind 

apro il file [config/services.php]()



    return ['facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI'),
    ],];
e in realtà tutte le chiave di cliente e secreto e uri dobbiamo aggiungere qua e in env





1- user name e password

2 - facebook

3- google

4- apple 

5-twitter 
