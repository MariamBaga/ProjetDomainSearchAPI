<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DomaineController extends Controller
{
    public function index()
    {
        try {
            // URL de l'API externe
            $apiUrl = 'http://api.mane.com/api/domains'; // Remplace cette URL par celle de l'API

            // Appel à l'API pour obtenir les domaines
            $response = Http::get($apiUrl);

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
