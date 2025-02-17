<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_employee()
    {
        // Create an admin user
        $admin = User::factory()->create(['role' => 'admin']);

        // Act as this admin
        $this->actingAs($admin);

        // Post data to create a new employee
        $response = $this->post('/admin/users', [
            'name' => 'John Doe',
            'cpf' => '12345678901',
            'email' => 'john@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        // Check redirection
        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'employee',
            'created_by' => $admin->id,
        ]);
    }
}
