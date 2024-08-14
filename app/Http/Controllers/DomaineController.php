<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DomaineController extends Controller
{
    public function index()
    {
        try {
            // URL de l'API externe
            $apiUrl = 'https://api.dev.name.com/v4/domains:search'; // URL correcte de l'API

            // Payload JSON pour la requête
            $payload = json_encode(['keyword' => 'example']);

            // Appel à l'API pour obtenir les domaines
            $response = Http::withBody($payload, 'application/json')
                            ->withBasicAuth('MariamBaga-test', 'eec8d7c3e23ec3156a2cbe3f0cc4139bff2365d0') // Remplace par les bons identifiants
                            ->post($apiUrl);

            if ($response->successful()) {
                $domains = $response->json();
                // Retourner les données au client sous forme de JSON
                return response()->json($domains);
            } else {
                // Gérer les erreurs et retourner une réponse JSON avec le message d'erreur
                return response()->json(['error' => 'Unable to fetch domains'], 500);
            }
        } catch (\Exception $e) {
            // Gérer les exceptions et retourner une réponse JSON avec le message d'erreur
            return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
        }
    }
}
