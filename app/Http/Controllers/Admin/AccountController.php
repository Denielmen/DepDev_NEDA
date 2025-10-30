<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /**
     * Display a listing of user accounts.
     */
    public function index()
    {
        // Fetch all users
        $users = User::all();

        // Return the view with user data
        return view('adminPanel.accounts', compact('users'));
    }

    /**
     * Toggle the active status of a user.
     */
    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully');
    }

    /**
     * Delete a user from the database.
     */
    public function deleteUser(User $user)
    {
        $userName = $user->first_name . ' ' . $user->last_name;

        // If this is the currently logged in user, logout first
        if (auth()->check() && auth()->id() === $user->id) {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        // Handle foreign key constraints by setting user_id to null in trainings
        \App\Models\Training::where('user_id', $user->id)->update(['user_id' => null]);

        // Delete the user from database (other tables have cascade delete)
        $user->delete();

        return redirect()->back()->with('success', 'The user ' . $userName . ' is successfully deleted.');
    }

    /**
     * Upload profile picture for a user.
     */
    public function uploadProfilePicture(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');

            // Update user record
            $user->profile_picture = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully',
                'image_url' => asset('storage/' . $path)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading profile picture: ' . $e->getMessage()
            ], 500);
        }
    }
}
