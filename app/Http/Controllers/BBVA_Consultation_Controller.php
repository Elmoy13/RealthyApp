<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class BBVA_Consultation_Controller extends Controller
{

    public function getTokenAccess(Request $request)
{
    $Authorization = 'YXBwLm14LlJlYWxQbGFjOnY4MGdDaDVPRU95Q3pkTk5uMVQkTDdjS0F6JVRGeUxORFhxZHFmMmJobnlCcFNpbnp6I0tjdyVVKnh1bUBTQWY=';

    $client = new Client([
        'base_uri' => 'https://connect.bbvabancomer.com',
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $Authorization,
        ],
        'verify' => false, // Desactiva la verificación SSL
    ]);

    try {
        $response = $client->post('/token?grant_type=client_credentials');
        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();

        if ($statusCode == 200) {
            $data = json_decode($responseBody);
            $request->session()->put('access_token', $data->access_token);

            return response()->json([
                'status' => 'success',
                'message' => 'Token de acceso obtenido y almacenado correctamente.',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener el token de acceso.',
            ], 500);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}

    public function getSuggestMortgages(Request $request){

    $token = $request->session()->get('access_token');

    $client = new Client([
        'base_uri' => 'https://apis.bbvabancomer.com',
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ],
        'verify' => false, // Desactiva la verificación SSL
    ]);

    $data = [
        "purpose" => [
            "id" => "HOUSE"
        ],
        "promoter" => [
            "name" => "1852OP5"
        ],
        "applicant" => [
            "hasPaycheck" => true
        ],
        "loanTerms" => [
            "years" => 20
        ],
        "consideredAmounts" => [
            [
                "type" => [
                    "id" => "PROPERTY_VALUE"
                ],
                "amount" => 550000.01, // Asegúrate de que sea un número de punto flotante
                "currency" => "MXN"
            ]
        ],
        "financingProgram" => [
            "type" => [
                "id" => "COFINAVIT"
            ],
            "contributionsBalance" => [
                "amount" => 10000.01, // Asegúrate de que sea un número de punto flotante
                "currency" => "MXN"
            ],
            "expenses" => [
                "percentage" => 3.0 // Asegúrate de que sea un número de punto flotante
            ],
            "grantedAmount" => [
                "amount" => 10000.01, // Asegúrate de que sea un número de punto flotante
                "currency" => "MXN"
            ]
        ]
    ];

    try {
        $response = $client->post('/mortgages-sbx/v1/suggest-mortgages', [
            'json' => $data,
        ]);

        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();

        return response()->json([
            'status' => 'success',
            'data' => json_decode($responseBody),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }


    }


    public function getSimulateMortgage(Request $request){

        $token = $request->session()->get('access_token');
    
        $client = new Client([
            'base_uri' => 'https://apis.bbvabancomer.com',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => false, // Desactiva la verificación SSL
        ]);
    
        $data = [
            "suggestMortgage" => [
                "id" => "6PCXAk0m8sZNVqZOT5R6hOcOMDfq80ILR+n9JKzJS/BZe7wnaBNT9lGCQKeULASb"
            ],
            "notarialFees" => [
                "percentage" => 3
            ],
            "investigationExpenses" => [
                "id" => "HOLDER"
            ]
        ];
    
        try {
            $response = $client->post('/mortgages-sbx/v1/simulate-mortgage', [
                'json' => $data,
            ]);
    
            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();
    
            return response()->json([
                'status' => 'success',
                'data' => json_decode($responseBody),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    
    
        }

        /* public function getTokenAccess(){

            $Authorization = 'YXBwLm14LlJlYWxQbGFjOnY4MGdDaDVPRU95Q3pkTk5uMVQkTDdjS0F6JVRGeUxORFhxZHFmMmJobnlCcFNpbnp6I0tjdyVVKnh1bUBTQWY=';

        
            $client = new Client([
                'base_uri' => 'https://connect.bbvabancomer.com',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . $Authorization,
                ],
                'verify' => false, // Desactiva la verificación SSL
            ]);
        
            try {
                $response = $client->post('/token?grant_type=client_credentials');
        
                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
        
                return response()->json([
                    'status' => 'success',
                    'data' => json_decode($responseBody),
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        
        
            } */
    

    
}