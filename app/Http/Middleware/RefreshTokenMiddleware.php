<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BBVA_Consultation_Controller;

class RefreshTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Verificar si la respuesta contiene un error de token expirado
        if ($this->isTokenExpired($response)) {
            // Renovar el token
            $controller = new BBVA_Consultation_Controller();
            $controller->getTokenAccess($request);

            // Reintentar la solicitud original con el nuevo token
            return $next($request);
        }

        return $response;
    }

    private function isTokenExpired($response)
    {
        $content = json_decode($response->getContent(), true);
        return isset($content['result']) && $content['result']['code'] == 401 && $content['result']['internal_code'] == 'invalid_token';
    }
}
