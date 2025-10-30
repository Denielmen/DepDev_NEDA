<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixAdminPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:fix-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix admin passwords by properly hashing them with bcrypt';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to fix admin passwords...');

        // Find admin users that might have unhashed passwords
        $adminUsers = User::where('role', 'Admin')
                         ->orWhere('user_id', 'like', 'Admin_%')
                         ->get();

        if ($adminUsers->isEmpty()) {
            $this->warn('No admin users found.');
            return;
        }

        foreach ($adminUsers as $user) {
            $this->info("Processing user: {$user->user_id} ({$user->first_name} {$user->last_name})");
            
            // Check if password is already properly hashed (bcrypt hashes start with $2y$)
            if (str_starts_with($user->password, '$2y$')) {
                $this->info("  ✓ Password already properly hashed");
                continue;
            }

            // Ask for confirmation before changing password
            if ($this->confirm("Do you want to rehash the password for {$user->user_id}?")) {
                // If password is not hashed, assume it's the plain text password and hash it
                $hashedPassword = Hash::make($user->password);
                
                // Update directly in database to bypass model events
                User::where('id', $user->id)->update(['password' => $hashedPassword]);
                
                $this->info("  ✓ Password successfully rehashed for {$user->user_id}");
            } else {
                $this->info("  - Skipped {$user->user_id}");
            }
        }

        $this->info('Admin password fixing completed!');
    }
}
