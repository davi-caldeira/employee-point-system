<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CepController extends Controller
{
    /**
     * Fetch address data for a given CEP from ViaCEP,
     * caching the result to avoid repeated requests.
     */
    public function getCep($cep)
    {
        // Validate basic CEP format (8 digits expected)
        if (!preg_match('/^[0-9]{8}$/', $cep)) {
            return response()->json(['error' => 'Invalid CEP format.'], 422);
        }

        // Cache the result for 24 hours to avoid repeated external calls
        return Cache::remember("cep:$cep", now()->addHours(24), function () use ($cep) {
            $url = "https://viacep.com.br/ws/{$cep}/json/";
            // Disable SSL verification for local/testing environments
            $response = Http::withoutVerifying()->get($url);

            if ($response->failed()) {
                return ['error' => 'Could not fetch data from ViaCEP.'];
            }

            return $response->json();
        });
    }
}
