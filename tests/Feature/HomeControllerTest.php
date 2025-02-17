<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_for_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/home');
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }
}
