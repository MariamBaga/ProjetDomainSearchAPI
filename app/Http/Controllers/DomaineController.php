<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DomaineController extends Controller
{
    // Méthode pour rechercher des domaines
    public function index(Request $request)
    {
        try {
            // Récupération des paramètres de recherche
            $keyword = $request->input('domain_name', 'example');
            $extension = $request->input('domain_extension', 'com');

            // URL de l'API externe
            $apiUrl = 'https://api.dev.name.com/v4/domains:search';

            // Payload JSON pour la requête
            $payload = json_encode(['keyword' => $keyword]);

            // Appel à l'API pour obtenir les domaines
            $response = Http::withBody($payload, 'application/json')->withBasicAuth('MariamBaga-test', 'eec8d7c3e23ec3156a2cbe3f0cc4139bff2365d0')->post($apiUrl);

            if ($response->successful()) {
                $domains = $response->json();
                return response()->json($domains);
            } else {
                return response()->json(['error' => 'Impossible de récupérer les domaines'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
        }
    }

    // Méthode pour enregistrer un domaine
    public function register(Request $request)
    {
        $domainName = $request->input('domain_name');
        $purchasePrice = $request->input('purchase_price', 12.99); // Prix d'achat par défaut

        try {
            // URL pour enregistrer un domaine
            $apiUrl = 'https://api.dev.name.com/v4/domains';

            // Création du payload
            $payload = json_encode([
                'domain' => $domainName,
                'purchasePrice' => $purchasePrice
            ]);

            // Appel API pour enregistrer le domaine
            $response = Http::withBody($payload, 'application/json')
                            ->withBasicAuth('MariamBaga-test', 'eec8d7c3e23ec3156a2cbe3f0cc4139bff2365d0') // Remplacez 'username' et 'token' par vos véritables identifiants
                            ->post($apiUrl);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Unable to register domain'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
        }
    }

    // Méthode pour renouveler un domaine
    public function renew(Request $request)
    {
        $domainName = $request->input('domain_name'); // Nom du domaine à renouveler
        $purchasePrice = $request->input('purchase_price', 12.99); // Prix d'achat du domaine (prix par défaut est 12.99)

        try {
            // URL pour renouveler le domaine
            $apiUrl = "https://api.dev.name.com/v4/domains/{$domainName}:renew";

            // Création du payload
            $payload = json_encode([
                'purchasePrice' => $purchasePrice
            ]);

            // Appel API pour renouveler le domaine
            $response = Http::withBody($payload, 'application/json')
                            ->withBasicAuth('MariamBaga-test', 'eec8d7c3e23ec3156a2cbe3f0cc4139bff2365d0') // Remplacez 'username' et 'token' par vos véritables identifiants
                            ->post($apiUrl);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Unable to renew domain'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
        }
    }

    // Méthode pour transférer un domaine
    public function transfer(Request $request)
    {
        $domainName = $request->input('domain_name'); // Nom du domaine à transférer
        $authCode = $request->input('auth_code'); // Code d'autorisation pour le transfert
        $purchasePrice = $request->input('purchase_price', 12.99); // Prix d'achat du domaine (prix par défaut est 12.99)

        try {
            // URL pour créer un transfert
            $apiUrl = 'https://api.dev.name.com/v4/transfers';

            // Création du payload
            $payload = json_encode([
                'domainName' => $domainName,
                'authCode' => $authCode,
                'purchasePrice' => $purchasePrice
            ]);

            // Appel API pour créer le transfert
            $response = Http::withBody($payload, 'application/json')
                            ->withBasicAuth('MariamBaga-test', 'eec8d7c3e23ec3156a2cbe3f0cc4139bff2365d0') // Remplacez 'username' et 'token' par vos véritables identifiants
                            ->post($apiUrl);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Unable to create transfer'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
        }
    }

}
