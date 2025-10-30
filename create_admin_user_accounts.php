<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Creating user accounts for admin staff...\n";

// User account data for the 4 admins
$admin_users = [
    [
        'user_id' => 'User_Casey',
        'last_name' => 'Bartolene',
        'first_name' => 'Casey',
        'mid_init' => null,
        'position' => 'Administrative Officer V',
        'position_start_date' => '2018-01-01', // Adjust as needed
        'years_in_csc' => 10, // Adjust as needed
        'government_start_date' => '2010-01-01', // Adjust as needed
        'division' => 'FAD - Finance and Administrative Division',
        'salary_grade' => 18, // Typical for Admin Officer V
        'role' => 'User',
        'superior' => 'Bretaña, Jennifer', // Reports to RD
        'password' => Hash::make('Casey2024!'), // Temporary password
        'is_active' => true,
        'is_superior_eligible' => false,
    ],
    [
        'user_id' => 'User_Maria',
        'last_name' => 'Padilla',
        'first_name' => 'Maria Sostheleen',
        'mid_init' => null,
        'position' => 'Administrative Officer V',
        'position_start_date' => '2017-01-01', // Adjust as needed
        'years_in_csc' => 12, // Adjust as needed
        'government_start_date' => '2008-01-01', // Adjust as needed
        'division' => 'FAD - Finance and Administrative Division',
        'salary_grade' => 18, // Typical for Admin Officer V
        'role' => 'User',
        'superior' => 'Bretaña, Jennifer', // Reports to RD
        'password' => Hash::make('Maria2024!'), // Temporary password
        'is_active' => true,
        'is_superior_eligible' => false,
    ],
    [
        'user_id' => 'User_Larhisse',
        'last_name' => 'Recamara',
        'first_name' => 'Larhisse',
        'mid_init' => null,
        'position' => 'Administrative Officer V',
        'position_start_date' => '2019-01-01', // Adjust as needed
        'years_in_csc' => 8, // Adjust as needed
        'government_start_date' => '2012-01-01', // Adjust as needed
        'division' => 'FAD - Finance and Administrative Division',
        'salary_grade' => 18, // Typical for Admin Officer V
        'role' => 'User',
        'superior' => 'Bretaña, Jennifer', // Reports to RD
        'password' => Hash::make('Larhisse2024!'), // Temporary password
        'is_active' => true,
        'is_superior_eligible' => false,
    ],
    [
        'user_id' => 'User_Cherilyn',
        'last_name' => 'Villafañe',
        'first_name' => 'Cherilyn',
        'mid_init' => null,
        'position' => 'Administrative Officer V',
        'position_start_date' => '2020-01-01', // Adjust as needed
        'years_in_csc' => 7, // Adjust as needed
        'government_start_date' => '2013-01-01', // Adjust as needed
        'division' => 'FAD - Finance and Administrative Division',
        'salary_grade' => 18, // Typical for Admin Officer V
        'role' => 'User',
        'superior' => 'Bretaña, Jennifer', // Reports to RD
        'password' => Hash::make('Cherilyn2024!'), // Temporary password
        'is_active' => true,
        'is_superior_eligible' => false,
    ],
];

try {
    $created_accounts = [];
    $updated_accounts = [];

    foreach ($admin_users as $user_data) {
        $existing_user = User::where('user_id', $user_data['user_id'])->first();
        
        if ($existing_user) {
            echo "User account {$user_data['user_id']} already exists. Updating information...\n";
            $existing_user->update($user_data);
            $updated_accounts[] = $user_data;
            echo "✓ {$user_data['first_name']} {$user_data['last_name']} account updated successfully.\n";
        } else {
            $new_user = User::create($user_data);
            $created_accounts[] = $user_data;
            echo "✓ {$user_data['first_name']} {$user_data['last_name']} account created successfully.\n";
        }
    }

    echo "\n=== USER ACCOUNT DETAILS ===\n";
    
    foreach ($admin_users as $user_data) {
        echo "{$user_data['first_name']} {$user_data['last_name']}:\n";
        echo "  - User ID: {$user_data['user_id']}\n";
        echo "  - Temporary Password: " . str_replace('2024!', '2024!', explode('$', $user_data['first_name'])[0] . '2024!') . "\n";
        echo "  - Role: User (can input own training data)\n";
        echo "  - Division: {$user_data['division']}\n\n";
    }
    
    echo "=== IMPORTANT NOTES ===\n";
    echo "1. These are separate USER accounts for the admin staff\n";
    echo "2. They can input their own training data as regular users\n";
    echo "3. Their admin accounts remain unchanged for administrative functions\n";
    echo "4. Please ask them to change their passwords on first login\n";
    echo "5. They can switch between admin and user roles as needed\n\n";
    
    echo "User accounts for admin staff created successfully!\n";
    echo "Created: " . count($created_accounts) . " new accounts\n";
    echo "Updated: " . count($updated_accounts) . " existing accounts\n";

} catch (Exception $e) {
    echo "Error creating user accounts: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
