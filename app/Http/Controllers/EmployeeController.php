<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Point;

class EmployeeController extends Controller
{
    /**
     * Show the employee dashboard with point registration and password change options.
     */
    public function dashboard()
    {
        $user = Auth::user();
        // Retrieve the user's points in descending order of registration time.
        $points = $user->points()->orderBy('registered_at', 'desc')->get();
        return view('employee.dashboard', compact('user', 'points'));
    }

    /**
     * Handle the point registration.
     */
    public function registerPoint(Request $request)
    {
        $user = Auth::user();

        // Create a new point record with the current timestamp.
        Point::create([
            'user_id' => $user->id,
            'registered_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Point registered successfully!');
    }

    /**
     * Show the form to change the employee's password.
     */
    public function showChangePasswordForm()
    {
        return view('employee.change-password');
    }

    /**
     * Process the password update.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'      => ['required'],
            'new_password'          => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Verify that the provided current password is correct.
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password. (The User model's cast will hash the new password.)
        $user->password = $request->new_password;
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully!');
    }
}
