<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Gasto;
use App\Models\Receita;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public function list()
    {
        $title = 'Pessoas';
        $items = pessoas();
        $key = 'pessoa';
        // dd($items);
        $route = 'pessoa.show';
        return view('cadastros.list', compact('title', 'items', 'key', 'route'));
    }

    public function show($pessoa)
    {
        $title = 'Detalhe da pessoa';
        $item = $pessoa;
        $receitas = Receita::where('devedor', $pessoa)->get();
        $gastos = Gasto::where('credor', $pessoa)->get();
        $route = 'pessoa.list';
        return view('cadastros.show', compact('title', 'item', 'receitas', 'gastos', 'route'));
    }
}
