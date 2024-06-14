<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Gasto;
use App\Models\Receita;
use Illuminate\Http\Request;

class LocalizadorController extends Controller
{
    public function list()
    {
        $title = 'Localizadores';
        $items = localizadores();
        // dd($items);
        $key = 'localizador';
        $route = 'localizador.show';
        return view('cadastros.list', compact('title', 'items', 'key', 'route'));
    }

    public function show($localizador)
    {
        $title = 'Detalhe do localizador';
        $item = $localizador;
        $receitas = Receita::where('localizador', $localizador)->get();
        $gastos = Gasto::where('localizador', $localizador)->get();
        $route = 'localizador.list';
        return view('cadastros.show', compact('title', 'item', 'receitas', 'gastos', 'route'));
    }
}
