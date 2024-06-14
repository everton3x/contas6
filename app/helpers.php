<?php

use App\Helpers\PeriodoHelper;
use App\Models\Periodo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

function periodo_fmt($periodo)
{
    return PeriodoHelper::fmt($periodo);
}

function data_fmt($data): string
{
    switch ($data) {
        case null:
            return '';
        case '':
            return '';
        case '0000-00-00':
            return '';
        default:
            break;
    }
    return date_create_from_format('Y-m-d', $data)->format('d/m/Y');
}

function money_fmt($value): string
{
    return number_format($value, 2, ',', '.');
}

function pessoas(): Collection
{
    $receitas = DB::table('receitas')->select('devedor')->distinct();
    return DB::table('gastos')->select('credor AS pessoa')->union($receitas)->distinct()->orderBy('pessoa')->get();
}

function agrupadores(): Collection
{
    $receitas = DB::table('receitas')->select('agrupador')->whereNotNull('agrupador')->distinct();
    return DB::table('gastos')->select('agrupador')->whereNotNull('agrupador')->union($receitas)->distinct()->orderBy('agrupador')->get();
}

function localizadores(): Collection
{
    $receitas = DB::table('receitas')->select('localizador')->whereNotNull('localizador')->distinct();
    return DB::table('gastos')->select('localizador')->whereNotNull('localizador')->union($receitas)->distinct()->orderBy('localizador')->get();
}

function mps(): Collection
{
    return DB::table('gastos')->select('mp')->distinct()->get();
}

function last_closed(): ?string
{
    $periodo = DB::table('periodos')->where('fechado', true)->orderByDesc('periodo')->first();
    return $periodo->periodo ?? null;
}

function first_opened(): ?string
{
    $periodo = DB::table('periodos')->where('fechado', false)->orderBy('periodo')->first();
    return $periodo->periodo ?? null;
}

function is_closed(string $periodo): bool
{
    if(Periodo::where('periodo', $periodo)->exists()) {
        return Periodo::where('periodo', $periodo)->first()->fechado;
    }

    Periodo::create([
        'periodo' => $periodo,
        'fechado' => false
    ]);
    return false;
}

function is_opened(string $periodo): bool
{
    if(Periodo::where('periodo', $periodo)->exists()) {
        return !Periodo::where('periodo', $periodo)->first()->fechado;
    }

    Periodo::create([
        'periodo' => $periodo,
        'fechado' => false
    ]);
    return true;
}


function resultado_periodo(string $periodo): float
{
    $receita = DB::table('receitas')->where('periodo', $periodo)->sum('valor');
    $despesa = DB::table('despesas')->where('periodo', $periodo)->sum('valor');
    $resultado = round($receita - $despesa, 2);
    return $resultado;
}

function resultado_acumulado(string $periodo): float
{
    $receita = DB::table('receitas')->where('periodo', '<=', $periodo)->sum('valor');
    $despesa = DB::table('despesas')->where('periodo', '<=', $periodo)->sum('valor');
    $resultado = round($receita - $despesa, 2);
    return $resultado;
}
