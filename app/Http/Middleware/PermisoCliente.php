<?php

namespace App\Http\Middleware;

use Closure;

class PermisoCliente
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //return $next($request);
        if ($this->permiso()) {
            return $next($request);
        }else {
            return redirect('/desembolso');
        }
    }

    private function permiso()
    {
        return session()->get('rol_nombre') == 'Cliente';
    }
}
