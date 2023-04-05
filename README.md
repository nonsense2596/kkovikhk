# KKO voting portal

Voting portal for VIK.HK. See the live site at https://kko.vik.hk . It uses AuthSCH (https://auth.sch.bme.hu/) for AAA with the following Laravel Socialite package: https://github.com/nonsense2596/ez-authsch .

Installation and database migration is done with Composer.

For the login system to work, edit config/authsch.php with the following properties generated at auth.sch.bme.hu:
```
<?php

return [
    'authsch' => [
        'client_id' => '',
        'client_secret' => '',
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

## Main screen
![img1](https://i.imgur.com/SIypODe.jpeg)

## Admin panel 1
![img2](https://i.imgur.com/w4WDBjQ.png)

## Admin panel 2
![img3](https://i.imgur.com/MhBuoz3.png)

## Voting screen
![img4](https://i.imgur.com/vQh5hjW.png)
