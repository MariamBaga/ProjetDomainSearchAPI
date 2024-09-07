<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DomaineController extends Controller
{
    // Méthode pour rechercher des domaines
    public function index(Request $request)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'domain_name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
        ]);
        try {
            // Récupération des paramètres de recherche
            $keyword = $request->input('domain_name', 'example');
            $extension = $request->input('domain_extension', 'com');

            // URL de l'API externe
            $apiUrl = 'https://api.dev.name.com/v4/domains:search';

            // Payload JSON pour la requête
            $payload = json_encode(['keyword' => $keyword]);

            // Appel à l'API pour obtenir les domaines
            $response = Http::withBody($payload, 'application/json')
                            ->withBasicAuth('MariamBaga-test', 'eec8d7c3e23ec3156a2cbe3f0cc4139bff2365d0')
                            ->post($apiUrl);

            if ($response->successful()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Domaines récupérés avec succès',
                    'data' => $response->json()
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Impossible de récupérer les domaines',
                    'error' => $response->json()
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ], 500);
        }
    }
public function register(Request $request)
{
    // Définir des valeurs par défaut
    $defaultDomainName = 'example.com';
    $defaultPurchasePrice = 0.00;

    // Validation des données d'entrée
    $validator = Validator::make($request->all(), [
        'domain_name' => 'required|string|max:255',
        'purchase_price' => 'sometimes|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Erreur de validation',
            'errors' => $validator->errors()
        ], 422);
    }

    // Récupérer les valeurs ou utiliser les valeurs par défaut
    $domainName = $request->input('domain_name', $defaultDomainName);
    $purchasePrice = $request->input('purchase_price', $defaultPurchasePrice);

    // Création du payload
    $payload = json_encode([
        'domain' => $domainName,
        'purchasePrice' => $purchasePrice
    ]);

    // Log payload pour vérification
    \Log::info('Payload: ' . $payload);

    try {
        // URL pour enregistrer un domaine
        $apiUrl = 'https://api.dev.name.com/v4/domains';

        // Appel API pour enregistrer le domaine
        $response = Http::withBody($payload, 'application/json')
                        ->withBasicAuth('MariamBaga-test', 'eec8d7c3e23ec3156a2cbe3f0cc4139bff2365d0')
                        ->post($apiUrl);

        // Log réponse pour vérification
        \Log::info('Response: ' . $response->body());

        if ($response->successful()) {
            return response()->json([
                'status' => true,
                'message' => 'Domaine enregistré avec succès',
                'data' => $response->json()
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Impossible d\'enregistrer le domaine',
                'error' => $response->body()
            ], $response->status());
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Exception: ' . $e->getMessage(),
        ], 500);
    }
}

public function renew(Request $request)
{
    // Définir une valeur par défaut pour le nom de domaine
    $defaultDomainName = 'object.cricket';
    $defaultPurchasePrice = 34.99;

    // Validation des données d'entrée
    $validator = Validator::make($request->all(), [
        'domain_name' => 'sometimes|string|max:255',
        'purchase_price' => 'sometimes|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Erreur de validation',
            'errors' => $validator->errors()
        ], 422);
    }

    // Récupérer les valeurs ou utiliser les valeurs par défaut
    $domainName = $request->input('domain_name', $defaultDomainName);
    $purchasePrice = $request->input('purchase_price', $defaultPurchasePrice);

    try {
        // URL pour renouveler le domaine
        $apiUrl = "https://api.dev.name.com/v4/domains/{$domainName}:renew";

        // Création du payload
        $payload = json_encode([
            'purchasePrice' => $purchasePrice
        ]);

        // Log payload pour vérification
        \Log::info('Payload: ' . $payload);

        // Appel API pour renouveler le domaine
        $response = Http::withBody($payload, 'application/json')
                        ->withBasicAuth('MariamBaga-test', 'eec8d7c3e23ec3156a2cbe3f0cc4139bff2365d0')
                        ->post($apiUrl);

        // Log réponse pour vérification
        \Log::info('Response: ' . $response->body());

        if ($response->successful()) {
            return response()->json([
                'status' => true,
                'message' => 'Domaine renouvelé avec succès',
                'data' => $response->json()
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Impossible de renouveler le domaine',
                'error' => $response->body()
            ], $response->status());
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Exception: ' . $e->getMessage(),
        ], 500);
    }
}


    // Méthode pour transférer un domaine
    public function transfer(Request $request)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'domain_name' => 'required|string|max:255',
            'auth_code' => 'required|string',
            'purchase_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $domainName = $request->input('domain_name');
        $authCode = $request->input('auth_code');
        $purchasePrice = $request->input('purchase_price');

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
                            ->withBasicAuth('MariamBaga-test', 'eec8d7c3e23ec3156a2cbe3f0cc4139bff2365d0')
                            ->post($apiUrl);

            if ($response->successful()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Transfert de domaine créé avec succès',
                    'data' => $response->json()
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Impossible de créer le transfert de domaine',
                    'error' => $response->json()
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ], 500);
        }
    }

}
