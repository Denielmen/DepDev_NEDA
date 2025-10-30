<?php

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Fixing admin passwords...\n";

// Find users with Admin_ prefix or admin role
$adminUsers = User::where('user_id', 'like', 'Admin_%')
                 ->orWhere('role', 'admin')
                 ->get();

if ($adminUsers->isEmpty()) {
    echo "No admin users found.\n";
    exit;
}

foreach ($adminUsers as $user) {
    echo "Processing: {$user->user_id} ({$user->first_name} {$user->last_name})\n";
    
    // Check if password is already hashed (bcrypt hashes start with $2y$)
    if (str_starts_with($user->password, '$2y$')) {
        echo "  ✓ Password already properly hashed\n";
        continue;
    }
    
    // Store the current password (assuming it's plain text)
    $plainPassword = $user->password;
    
    // Hash the password
    $hashedPassword = Hash::make($plainPassword);
    
    // Update the password directly in database
    User::where('id', $user->id)->update(['password' => $hashedPassword]);
    
    echo "  ✓ Password rehashed for {$user->user_id}\n";
    echo "  Original: " . substr($plainPassword, 0, 3) . "***\n";
    echo "  New hash: " . substr($hashedPassword, 0, 20) . "...\n";
}

echo "\nAdmin password fixing completed!\n";
echo "You can now login with the original passwords.\n";
