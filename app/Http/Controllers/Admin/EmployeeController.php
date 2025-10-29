<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Log the incoming request data
            Log::info('Update request data:', $request->all());
            
            $validated = $request->validate([
                'user_id' => 'required|string|max:255|unique:users,user_id,' . $id,
                'first_name' => 'required|string|max:255',
                'mid_init' => 'nullable|string|max:2',
                'last_name' => 'required|string|max:255',
                'salary_grade' => 'required|string|max:255',
                'position_start_date' => 'nullable|date|before_or_equal:today',
                'government_start_date' => 'nullable|date|before_or_equal:today',
                'division' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'superior' => 'nullable|string|max:255',
            ]);

            // Use the years_in_csc value provided by admin (no automatic calculation)

            // Log the validated data
            Log::info('Validated data:', $validated);

            $user->update($validated);

            // Log the updated user data
            Log::info('Updated user data:', $user->toArray());

            return redirect()->back()->with('success', 'Employee profile updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating employee profile: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Failed to update employee profile: ' . $e->getMessage());
        }
    }
} 