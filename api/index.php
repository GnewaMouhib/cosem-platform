<?php

// Forward Vercel requests to normal index.php
// Prepare the temporary /tmp filesystem for Laravel on serverless
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

putenv('APP_STORAGE=' . $storagePath);
$_ENV['APP_STORAGE'] = $storagePath;
$_SERVER['APP_STORAGE'] = $storagePath;

require __DIR__ . '/../public/index.php';
