<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Gasto;
use App\Models\Receita;
use Illuminate\Http\Request;

class AgrupadorController extends Controller
{
    public function list()
    {
        $title = 'Agrupadores';
        $items = agrupadores();
        // dd($items);
        $key = 'agrupador';
        $route = 'agrupador.show';
        return view('cadastros.list', compact('title', 'items', 'key', 'route'));
    }

    public function show($agrupador)
    {
        $title = 'Detalhe da agrupador';
        $item = $agrupador;
        $receitas = Receita::where('agrupador', $agrupador)->get();
        $gastos = Gasto::where('agrupador', $agrupador)->get();
        $route = 'agrupador.list';
        return view('cadastros.show', compact('title', 'item', 'receitas', 'gastos', 'route'));
    }
}
