<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test mail config
echo "=== TESTING EMAIL CONFIGURATION ===\n";
echo "MAIL_MAILER: " . env('MAIL_MAILER') . "\n";
echo "MAIL_SCHEME: " . env('MAIL_SCHEME') . "\n";
echo "MAIL_HOST: " . env('MAIL_HOST') . "\n";
echo "MAIL_PORT: " . env('MAIL_PORT') . "\n";
echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS') . "\n";
echo "\n";

// Check if we can create the mailer
try {
    $mailer = app('mail.mailer');
    echo "✅ Mailer instance created successfully\n";
    echo "Mailer class: " . get_class($mailer) . "\n";
} catch (\Exception $e) {
    echo "❌ Error creating mailer: " . $e->getMessage() . "\n";
}
