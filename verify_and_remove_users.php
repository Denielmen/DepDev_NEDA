<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Users to remove
$usersToRemove = [
    'User_larhisse' => 'Larhisse Recamara',
    'User_Maria' => 'Maria Sostheleen Padilla',
    'User_Cherilyn' => 'Cherilyn Villafañe',
    'User_Casey' => 'Casey Bartolene'
];

echo "=== USER ACCOUNT CLEANUP TOOL ===\n\n";

try {
    // Check if users exist in the database
    echo "Checking for user accounts to remove...\n";
    
    $foundUsers = [];
    
    foreach ($usersToRemove as $userId => $userName) {
        $user = User::withTrashed()->where('user_id', $userId)->first();
        
        if ($user) {
            $status = $user->trashed() ? '[SOFT-DELETED]' : '[ACTIVE]';
            $foundUsers[] = [
                'id' => $user->id,
                'user_id' => $userId,
                'name' => $user->first_name . ' ' . $user->last_name,
                'status' => $status,
                'deleted_at' => $user->deleted_at
            ];
            echo "- Found {$status} {$user->first_name} {$user->last_name} ({$userId})\n";
        } else {
            echo "- Not found: {$userName} ({$userId})\n";
        }
    }
    
    if (empty($foundUsers)) {
        echo "\nNo user accounts found to remove.\n";
        exit(0);
    }
    
    // Ask for confirmation
    echo "\nThese users will be PERMANENTLY deleted. Continue? (yes/no): ";
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    
    if(trim($line) != 'yes'){
        echo "\nOperation cancelled.\n";
        exit(0);
    }
    
    fclose($handle);
    
    // Force delete users
    echo "\nRemoving users...\n";
    
    DB::beginTransaction();
    
    foreach ($foundUsers as $user) {
        try {
            // Force delete (bypass soft delete if enabled)
            $deleted = User::withTrashed()->where('id', $user['id'])->forceDelete();
            
            if ($deleted) {
                echo "✓ Permanently deleted: {$user['name']} ({$user['user_id']})\n";
                
                // Clean up any remaining sessions
                DB::table('sessions')
                    ->where('user_id', $user['id'])
                    ->delete();
            }
        } catch (\Exception $e) {
            echo "! Error deleting {$user['name']}: " . $e->getMessage() . "\n";
        }
    }
    
    DB::commit();
    
    // Final check
    echo "\nVerifying removal...\n";
    $allRemoved = true;
    
    foreach ($usersToRemove as $userId => $userName) {
        $user = User::withTrashed()->where('user_id', $userId)->first();
        
        if ($user) {
            echo "! WARNING: User still exists: {$user->first_name} {$user->last_name} ({$userId})\n";
            $allRemoved = false;
        }
    }
    
    if ($allRemoved) {
        echo "\n✓ All specified user accounts have been successfully removed.\n";
    } else {
        echo "\n! Some users could not be removed. You may need to check database constraints.\n";
    }
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\nERROR: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\nCleanup complete.\n";
