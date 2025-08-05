<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
}
