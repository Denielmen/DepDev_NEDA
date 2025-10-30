<?php

// Simple password reset script
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Reset Admin_Evelyn password
$evelyn = User::where('user_id', 'Admin_Evelyn')->first();
if ($evelyn) {
    $evelyn->password = Hash::make('evelyn123');
    $evelyn->save();
    echo "Admin_Evelyn password set to: evelyn123\n";
}

// Reset Admin_Jennifer password  
$jennifer = User::where('user_id', 'Admin_Jennifer')->first();
if ($jennifer) {
    $jennifer->password = Hash::make('jennifer123');
    $jennifer->save();
    echo "Admin_Jennifer password set to: jennifer123\n";
}

echo "Password reset complete!\n";
