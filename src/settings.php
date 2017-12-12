<?php

use josegonzalez\Dotenv\Loader as EnvLoader;

$environment = (new EnvLoader('../environments/development.env'))
    ->parse()
    ->toArray();

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'db'    => [
            'host'   => $environment['DB_HOST'],
            'dbname'   => $environment['DB_NAME'],
            'user'   => $environment['DB_USER'],
            'pass'   => $environment['DB_PASS']
        ]
    ],
];
