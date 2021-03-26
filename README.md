note to self


create config/authsch.php with the following properties:
```
<?php

return [
    'authsch' => [
        'client_id' => '',
        'client_secret' => '',
        'redirect' => 'http://localhost:8000/auth/schonherz/callback',
    ],

    'authsch_scopes' =>[
        "basic",
        "displayName",
        "mail",
        "bmeunitscope",
    ],
];
```
