<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if ($role === 'admin' && !$user->isAdmin()) {
            abort(403, 'Accès réservé aux administrateurs');
        }
        
        if ($role === 'etudiant' && !$user->isEtudiant()) {
            abort(403, 'Accès réservé aux étudiants');
        }

        return $next($request);
    }
}