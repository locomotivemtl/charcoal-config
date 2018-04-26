<?php

return [
    'host'    => 'localhost',
    'port'    => 11211,
    'memory'  => false,
    'drivers' => [
        'pdo_mysql',
        'pdo_pgsql',
        'pdo_sqlite',
    ],
    'database' => [
        'name' => 'mydb',
        'user' => 'myname',
        'pass' => 'secret',
    ],
];
