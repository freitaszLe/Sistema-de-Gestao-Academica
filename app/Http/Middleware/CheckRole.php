<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verifica se o usuário não está logado OU se o papel dele não é o permitido
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Se não tiver permissão, retorna um erro 403 (Acesso Proibido)
            abort(403, 'ACESSO NÃO AUTORIZADO.');
        }

        // Se o usuário tiver o papel correto, permite que a requisição continue
        return $next($request);
    }
}
