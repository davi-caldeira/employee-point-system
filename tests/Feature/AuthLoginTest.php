<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_redirects_to_admin_dashboard()
    {
        $admin = User::factory()->create([
            'role'     => 'admin',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email'    => $admin->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_employee_login_redirects_to_employee_dashboard()
    {
        $employee = User::factory()->create([
            'role'     => 'employee',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email'    => $employee->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('employee.dashboard'));
    }
}
