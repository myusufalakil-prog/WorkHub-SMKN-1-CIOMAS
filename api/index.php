<?php

// Pastikan folder cache dan view Blade di /tmp dibuat secara dinamis untuk lingkungan Serverless Vercel
$storageDirs = [
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Forward request ke front controller resmi Laravel
require __DIR__ . '/../public/index.php';
