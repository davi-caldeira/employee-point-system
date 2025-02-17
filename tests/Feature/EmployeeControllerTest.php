<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Point;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an employee can register a point.
     */
    public function test_employee_can_register_point()
    {
        // Create an employee user
        $employee = User::factory()->create([
            'role'     => 'employee',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($employee);

        // Ensure there are no points yet
        $this->assertDatabaseCount('points', 0);

        // Send POST request to register point
        $response = $this->post(route('employee.registerPoint'));

        // Expect a redirect (back to dashboard)
        $response->assertRedirect();
        // Verify that a new point record was created
        $this->assertDatabaseCount('points', 1);
        $this->assertDatabaseHas('points', [
            'user_id' => $employee->id,
        ]);
    }

    /**
     * Test that an employee can change their password when current password is valid.
     */
    public function test_employee_can_change_password_with_valid_current_password()
    {
        // Create an employee with a known password
        $employee = User::factory()->create([
            'role'     => 'employee',
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($employee);

        $data = [
            'current_password'          => 'oldpassword',
            'new_password'              => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ];

        $response = $this->post(route('employee.updatePassword'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Password changed successfully!');

        // Refresh user data and check new password hash
        $employee->refresh();
        $this->assertTrue(Hash::check('newpassword123', $employee->password));
    }

    /**
     * Test that password change fails if the current password is invalid.
     */
    public function test_employee_change_password_fails_with_invalid_current_password()
    {
        // Create an employee with a known password
        $employee = User::factory()->create([
            'role'     => 'employee',
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($employee);

        $data = [
            'current_password'          => 'wrongpassword',
            'new_password'              => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ];

        $response = $this->post(route('employee.updatePassword'), $data);

        // Expect error for invalid current password
        $response->assertSessionHasErrors(['current_password']);

        $employee->refresh();
        $this->assertTrue(Hash::check('oldpassword', $employee->password));
    }
}
