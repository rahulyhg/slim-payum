<?php
require_once 'public/prepare.php';

// sphinx configuration
return [
    'paths'                => [
        'migrations' => 'migrations',
    ],
    'migration_base_class' => '\AppMain\Migration\Migration',
    'environments'         => [
        'default_migration_table' => 'phinxlog',
        'default_database'        => 'dev',
        'dev'                     => [
            'adapter' => 'mysql',
            'host'    => getenv('DB_HOST'),
            'name'    => getenv('DB_DATABASE'),
            'user'    => getenv('DB_USERNAME'),
            'pass'    => getenv('DB_PASSWORD'),
            'port'    => getenv('DB_PORT'),
        ],
    ],
];
