<?php

namespace App\Http\Middleware;

use App\Http\Controllers\PeriodoController;
use App\Models\Despesa;
use App\Models\Periodo;
use App\Models\Receita;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeriodoIsOpen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->periodo) $periodo = $request->periodo;
        if($request->receita_id) $periodo = Receita::find($request->receita_id)->periodo;
        if($request->despesa_id) $periodo = Despesa::find($request->despesa_id)->periodo;

        if(is_opened($periodo)) {
            return $next($request);
        }

        return back()->withErrors(['periodo' => 'Período fechado não pode receber registros.']);
    }
}
