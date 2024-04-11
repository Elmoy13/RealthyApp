<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class BBVA_Consultation_Controller extends Controller
{

    public function getSuggestMortgages(){

    $token = 'eyJ6aXAiOiJERUYiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiUlNBLU9BRVAifQ.L6Bk8cf4NVmcv94foM75pNDtojlafVWbV560eKmTBKQWrM-sNXrV6GrSqt8VaviApu7L--uAIcUSNrS1HlpMShGSVCDufmqCuCQJKz1wz1LmzCvx_I-oLoO20J_9VqsIDbi5nZTPh58ZSsxH-PnihRRWeuqxHiwa9xmIWTQhe54GR-KWczc_i_jklTT3tX4ynhwRWOHQlQXTZepFSl7CMzOfkITpCWw-y5pKU5Nwu7Nwryh-A1t_CFwuaqqck-_wMNXwupdkxNvITE5DSOzakD-H9v7b-QDFf19fSCx2b4dc1zlxayEXiysXGBIoXvjChXwhs8OE0YOFIB4yIkH2nw.VdFHCAqobnn2FPuP.DeQg2h0qoEWRpxsAhU3wHlfbXBNdiThCr3iOhW_7Hu9rtHshxeV4huX0wM11hy1OmJQ4ffr5bR6apesSFX4JQC2pjh8jCPrIWQ4P2k-jqn3iVjHF6j00RTcPLN_zsg13b3NfHF-5ck57WEXNYmJtD2YwEBd3Q6ucL857IUX3_N_4mkg_k7kU_zuZE13LKSqBbNpGuEs7hAfBmxESxvHoYXa3IGswapuEpw.kGVmBaAJiKkLAt2M80mUfw';

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


    public function getSimulateMortgage(){

        $token = 'eyJ6aXAiOiJERUYiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiUlNBLU9BRVAifQ.L6Bk8cf4NVmcv94foM75pNDtojlafVWbV560eKmTBKQWrM-sNXrV6GrSqt8VaviApu7L--uAIcUSNrS1HlpMShGSVCDufmqCuCQJKz1wz1LmzCvx_I-oLoO20J_9VqsIDbi5nZTPh58ZSsxH-PnihRRWeuqxHiwa9xmIWTQhe54GR-KWczc_i_jklTT3tX4ynhwRWOHQlQXTZepFSl7CMzOfkITpCWw-y5pKU5Nwu7Nwryh-A1t_CFwuaqqck-_wMNXwupdkxNvITE5DSOzakD-H9v7b-QDFf19fSCx2b4dc1zlxayEXiysXGBIoXvjChXwhs8OE0YOFIB4yIkH2nw.VdFHCAqobnn2FPuP.DeQg2h0qoEWRpxsAhU3wHlfbXBNdiThCr3iOhW_7Hu9rtHshxeV4huX0wM11hy1OmJQ4ffr5bR6apesSFX4JQC2pjh8jCPrIWQ4P2k-jqn3iVjHF6j00RTcPLN_zsg13b3NfHF-5ck57WEXNYmJtD2YwEBd3Q6ucL857IUX3_N_4mkg_k7kU_zuZE13LKSqBbNpGuEs7hAfBmxESxvHoYXa3IGswapuEpw.kGVmBaAJiKkLAt2M80mUfw';
    
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

        public function getTokenAccess(){

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
        
        
            }
    

    
}