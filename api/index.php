<?php

// Forward Vercel requests to normal index.php
// Prepare temporary storage directories in /tmp for serverless environment
$storagePath = '/tmp/storage';

$dirs = [
    $storagePath . '/app',
    $storagePath . '/app/public',
    $storagePath . '/framework',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Copy pre-seeded SQLite database to writable /tmp if using sqlite
$tmpDb = '/tmp/database.sqlite';
$seedDb = __DIR__ . '/../database/database.sqlite';
if (!file_exists($tmpDb) && file_exists($seedDb)) {
    @copy($seedDb, $tmpDb);
}

putenv('APP_STORAGE=' . $storagePath);
$_ENV['APP_STORAGE'] = $storagePath;
$_SERVER['APP_STORAGE'] = $storagePath;

if (!getenv('DB_CONNECTION') || getenv('DB_CONNECTION') === 'sqlite') {
    putenv('DB_CONNECTION=sqlite');
    putenv('DB_DATABASE=' . $tmpDb);
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = $tmpDb;
    $_SERVER['DB_CONNECTION'] = 'sqlite';
    $_SERVER['DB_DATABASE'] = $tmpDb;
}

require __DIR__ . '/../public/index.php';
