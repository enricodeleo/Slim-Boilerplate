<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'view' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        // PHPMailer settings
        // already configured for SendGrid with the tastaly's account
        'mail' => [
            'auth' => true,
            'host' => 'smtp.sendgrid.net',
            'secure' => 'tls',
            'port' => '587',
            'username' => 'username',
            'password' => 'p4ssw0rd'
        ],

        // Database settings
        // see http://medoo.in/api/new for MSSQL or MySQL configurations
        'db' => [
            'database_type' => 'sqlite',
            'database_file' => '../data/app.sqlite', // path to sqlite file
            'charset'   => 'utf8',
            'tables' => [
                // put here all the tables and schemas that the db should create
                'subscriptions' => '`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `email` TEXT NOT NULL UNIQUE, `ip` TEXT, `joinedOn` TEXT NOT NULL'
            ]
        ]
    ],
];
