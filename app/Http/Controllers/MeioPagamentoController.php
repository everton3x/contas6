<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Gasto;
use App\Models\Receita;
use Illuminate\Http\Request;

class MeioPagamentoController extends Controller
{
    public function list()
    {
        $title = 'Meios de Pagamento';
        $items = mps();
        // dd($items);
        $key = 'mp';
        $route = 'mp.show';
        return view('cadastros.list', compact('title', 'items', 'key', 'route'));
    }

    public function show($mp)
    {
        $title = 'Detalhe do meio de pagamento';
        $item = $mp;
        $receitas = Receita::where('mp', $mp)->get();
        $gastos = Gasto::where('mp', $mp)->get();
        $route = 'mp.list';
        return view('cadastros.show', compact('title', 'item', 'receitas', 'gastos', 'route'));
    }
}
