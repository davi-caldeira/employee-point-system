<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;

class CepTest extends TestCase
{
    use RefreshDatabase;

    public function test_cep_endpoint_returns_data()
    {
        // Fake the HTTP response from ViaCEP
        Http::fake([
            'viacep.com.br/ws/01001000/json/' => Http::response([
                'cep' => '01001-000',
                'logradouro' => 'Praça da Sé',
                'complemento' => 'lado ímpar',
                'bairro' => 'Sé',
                'localidade' => 'São Paulo',
                'uf' => 'SP',
                'ibge' => '3550308',
                'gia' => '1004',
                'ddd' => '11',
                'siafi' => '7107'
            ], 200),
        ]);

        // Create a user and authenticate for the route protection
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call the endpoint
        $response = $this->get('/api/cep/01001000');

        $response->assertStatus(200)
            ->assertJsonFragment(['logradouro' => 'Praça da Sé']);
    }

    public function test_cep_endpoint_invalid_format()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/cep/1234567');
        $response->assertStatus(422)
            ->assertJson(['error' => 'Invalid CEP format.']);
    }
}
