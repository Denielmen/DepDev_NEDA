<?php

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Resetting admin passwords to known values...\n";

// Define new passwords
$adminPasswords = [
    'Admin_Evelyn' => 'admin123',
    'Admin_Jennifer' => 'admin123'
];

foreach ($adminPasswords as $userId => $newPassword) {
    $user = User::where('user_id', $userId)->first();
    
    if ($user) {
        // Update password
        $user->update(['password' => Hash::make($newPassword)]);
        echo "✓ Password reset for {$userId}: {$newPassword}\n";
    } else {
        echo "✗ User {$userId} not found\n";
    }
}

echo "\nAdmin passwords have been reset!\n";
echo "Login credentials:\n";
echo "- Admin_Evelyn: admin123\n";
echo "- Admin_Jennifer: admin123\n";
