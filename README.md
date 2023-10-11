# KKO voting portal

Voting portal for VIK.HK. See the live site at https://kko.vik.hk . It uses AuthSCH (https://auth.sch.bme.hu/) for AAA with the following Laravel Socialite package: https://github.com/nonsense2596/ez-authsch .

## Main screen
![img1](https://i.imgur.com/SIypODe.jpeg)

## Admin panel 1
![img2](https://i.imgur.com/w4WDBjQ.png)

## Admin panel 2
![img3](https://i.imgur.com/MhBuoz3.png)

## Voting screen
![img4](https://i.imgur.com/vQh5hjW.png)

## Installation

The easiest way to get everything up and running is by using XAMP.
Required parts: apache, php, mysql

There aren't much things you need to take care of, but it's hard to debug the weird side effects
that a wrong configuration can cause, thus double-check everything during the setup.

0. Make sure you have a database server and a high performance web server and reverse proxy server
installed and running.

1. Copy or rename the `.env.example` to `.env` and then edit the fields related to database connection
and e-mailing.

2. If you would like to use the *AuthSCH* login system, create file `config/authsch.php` and insert
the following into it.
```php
<?php

return [
    'authsch' => [
        'client_id' => '<INSERT YOUR CLIENT ID HERE>',
        'client_secret' => '<INSERT YOUR SECRET HERE>',
        'redirect' => 'https://deployment.url/auth/schonherz/callback',
    ],

    'authsch_scopes' =>[
        "basic",
        "displayName",
        "mail",
        "bmeunitscope",
    ],
];
```

3. Migrate the database.
```sh
php artisan migrate
```

4. If you do not have the project root inside htdocs (or the server root), run server with.
```sh
php artisan serve
```

5. If you need the e-mail system working, run the background worker with.
```sh
php artisan queue:work
```

## Debugging

- DD(D) can turn out to be really helpful (logs are stored at storage/logs/laravel.log by default).

