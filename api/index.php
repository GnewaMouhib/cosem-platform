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

// Copy pre-seeded SQLite database to writable /tmp
$tmpDb = '/tmp/database.sqlite';
$seedDb = __DIR__ . '/../database/database.sqlite';
if (!file_exists($tmpDb)) {
    if (file_exists($seedDb) && filesize($seedDb) > 0) {
        @copy($seedDb, $tmpDb);
    } else {
        @touch($tmpDb);
    }
}

// Default environment settings for serverless
$appKey = 'base64:pJEj2iLs74knZNGRW419b8fo+/5MqUzdYBR8E3WZ9Ps=';
putenv('APP_KEY=' . $appKey);
$_ENV['APP_KEY'] = $appKey;
$_SERVER['APP_KEY'] = $appKey;

putenv('APP_STORAGE=' . $storagePath);
$_ENV['APP_STORAGE'] = $storagePath;
$_SERVER['APP_STORAGE'] = $storagePath;

putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';
$_SERVER['LOG_CHANNEL'] = 'stderr';

putenv('SESSION_DRIVER=cookie');
$_ENV['SESSION_DRIVER'] = 'cookie';

putenv('CACHE_STORE=array');
$_ENV['CACHE_STORE'] = 'array';

putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=' . $tmpDb);
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $tmpDb;
$_SERVER['DB_CONNECTION'] = 'sqlite';
$_SERVER['DB_DATABASE'] = $tmpDb;

require __DIR__ . '/../public/index.php';
