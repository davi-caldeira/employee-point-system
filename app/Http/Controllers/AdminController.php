<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * List all employee users.
     */
    public function indexUsers()
    {
        $users = User::where('role', 'employee')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form to create a new employee.
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a new employee.
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'cpf'        => 'required|string|max:14|unique:users',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
            'position'   => 'nullable|string',
            'birth_date' => 'nullable|date',
            'zip_code'   => 'nullable|string',
            'address'    => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'employee';
        $validated['created_by'] = auth()->user()->id;

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form to edit an existing employee.
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the employee information.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name'       => 'required|string|max:255',
            'cpf'        => 'required|string|max:14|unique:users,cpf,'.$user->id,
            'email'      => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'position'   => 'nullable|string',
            'birth_date' => 'nullable|date',
            'zip_code'   => 'nullable|string',
            'address'    => 'nullable|string',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Delete an employee.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Employee deleted successfully.');
    }

    /**
     * Display point records of employees (subordinate to the current admin)
     * with optional date filtering.
     */
    public function viewPoints(Request $request)
    {
        $query = Point::query();

        // Limit to points of employees created by the current admin
        $query->whereHas('user', function($q) {
            $q->where('created_by', auth()->user()->id);
        });

        if ($request->filled('start_date')) {
            $query->where('registered_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('registered_at', '<=', $request->end_date);
        }

        $points = $query->with(['user.creator'])->orderBy('registered_at', 'desc')->paginate(10);

        return view('admin.points.index', compact('points'));
    }
}
