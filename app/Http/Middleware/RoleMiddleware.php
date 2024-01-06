<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use app\models\User;
use app\models\Role;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) return redirect('login');

        $user = Auth::user();
    
        foreach($roles as $role) {
            // Check if user has the role
            if($user->roles->contains('name', $role)) {
                return $next($request);
            }
        }
    
        return redirect('home'); // Or to a 403 Forbidden page
    }
}
