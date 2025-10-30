<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Creating read-only admin accounts for RD and ARD...\n";

// Account data for Jennifer Bretaña (Regional Director)
$jennifer_data = [
    'user_id' => 'Admin_Jennifer',
    'last_name' => 'Bretaña',
    'first_name' => 'Jennifer',
    'mid_init' => null,
    'position' => 'Regional Director',
    'position_start_date' => '2020-01-01', // Adjust as needed
    'years_in_csc' => 15, // Adjust as needed
    'government_start_date' => '2005-01-01', // Adjust as needed
    'division' => 'ORD - Office of the Regional Director',
    'salary_grade' => 26, // Typical for Regional Director
    'role' => 'Admin',
    'superior' => null, // RD typically has no superior in regional office
    'password' => Hash::make('Jennifer2024!'), // Temporary password
    'is_active' => true,
    'is_superior_eligible' => true,
];

// Account data for Evelyn Castro (Assistant Regional Director)
$evelyn_data = [
    'user_id' => 'Admin_Evelyn',
    'last_name' => 'Castro',
    'first_name' => 'Evelyn',
    'mid_init' => null,
    'position' => 'Assistant Regional Director',
    'position_start_date' => '2018-01-01', // Adjust as needed
    'years_in_csc' => 12, // Adjust as needed
    'government_start_date' => '2008-01-01', // Adjust as needed
    'division' => 'ORD - Office of the Regional Director',
    'salary_grade' => 25, // Typical for Assistant Regional Director
    'role' => 'Admin',
    'superior' => 'Bretaña, Jennifer', // Reports to RD
    'password' => Hash::make('Evelyn2024!'), // Temporary password
    'is_active' => true,
    'is_superior_eligible' => true,
];

try {
    // Check if Jennifer's account already exists
    $jennifer = User::where('user_id', 'Admin_Jennifer')->first();
    if ($jennifer) {
        echo "Admin_Jennifer account already exists. Updating information...\n";
        $jennifer->update($jennifer_data);
        echo "✓ Admin_Jennifer account updated successfully.\n";
    } else {
        $jennifer = User::create($jennifer_data);
        echo "✓ Admin_Jennifer account created successfully.\n";
    }

    // Check if Evelyn's account already exists
    $evelyn = User::where('user_id', 'Admin_Evelyn')->first();
    if ($evelyn) {
        echo "Admin_Evelyn account already exists. Updating information...\n";
        $evelyn->update($evelyn_data);
        echo "✓ Admin_Evelyn account updated successfully.\n";
    } else {
        $evelyn = User::create($evelyn_data);
        echo "✓ Admin_Evelyn account created successfully.\n";
    }

    echo "\n=== ACCOUNT DETAILS ===\n";
    echo "Jennifer Bretaña (Regional Director):\n";
    echo "  - User ID: Admin_Jennifer\n";
    echo "  - Temporary Password: Jennifer2024!\n";
    echo "  - Access Level: Read-only Admin (can view everything, cannot modify)\n\n";
    
    echo "Evelyn Castro (Assistant Regional Director):\n";
    echo "  - User ID: Admin_Evelyn\n";
    echo "  - Temporary Password: Evelyn2024!\n";
    echo "  - Access Level: Read-only Admin (can view everything, cannot modify)\n\n";
    
    echo "=== IMPORTANT NOTES ===\n";
    echo "1. Both accounts have read-only access to all admin functions\n";
    echo "2. They can view all training data, participants, and reports\n";
    echo "3. They cannot create, edit, or delete any data\n";
    echo "4. Please ask them to change their passwords on first login\n";
    echo "5. The ReadOnlyAdmin middleware is already configured for these accounts\n\n";
    
    echo "Read-only admin accounts created successfully!\n";

} catch (Exception $e) {
    echo "Error creating accounts: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
