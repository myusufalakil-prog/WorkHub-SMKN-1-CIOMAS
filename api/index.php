<?php

// Tandai lingkungan Serverless Vercel
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Siapkan struktur folder writable di /tmp untuk Laravel
$storagePath = '/tmp/storage';
$folders = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/testing',
    $storagePath . '/logs',
    $storagePath . '/app/public',
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        @mkdir($folder, 0755, true);
    }
}

// Teruskan request ke front controller resmi Laravel
require __DIR__ . '/../public/index.php';
