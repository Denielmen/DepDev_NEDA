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

        // Delete the user from database
        $user->delete();

        return redirect()->back()->with('success', 'The user ' . $userName . ' is successfully deleted.');
    }
}
