<?php

namespace App\Http\Middleware;

use App\Models\RequestStat;
use Closure;
use Illuminate\Http\Request;

class RequestStatMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Récupérer le chemin de l'endpoint
        $endpoint = $request->path();

        // Chercher l'endpoint dans la base de données
        $requestStat = RequestStat::where('endpoint', $endpoint)->first();

        // Si l'endpoint existe, incrémenter la valeur de request_count
        if ($requestStat) {
            $requestStat->increment('request_count');
        } else {
            // Sinon, créer une nouvelle entrée avec un compteur de requêtes à 1
            RequestStat::create([
                'endpoint' => $endpoint,
                'request_count' => 1,
            ]);
        }

        // Continuer le traitement de la requête
        return $next($request);
    }
}
