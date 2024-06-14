<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function receita(Request $request)
    {
        $periodo1 = $request->periodo1 ?? date('Y-m');
        $periodo2 = $request->periodo2 ?? date('Y-m');
        $devedor = $request->devedor ?? '%';
        $valor1 = $request->valor1 ?? 0.01;
        $valor2 = $request->valor2 ?? 999999.99;
        $agrupador = $request->agrupador ?? '%';
        $localizador = $request->localizador ?? '%';

        $receitas = DB::table('receitas')->whereBetween('periodo', [$periodo1, $periodo2])->where('devedor', 'like', $devedor)->whereBetween('valor', [$valor1, $valor2])->where('agrupador', 'like', $agrupador)->where('localizador', 'like', $localizador)->get();

        return view('filter.receita', compact('periodo1', 'periodo2', 'devedor', 'valor1', 'valor2', 'agrupador', 'localizador', 'receitas'));
    }
    public function despesa(Request $request)
    {
        $periodo1 = $request->periodo1 ?? date('Y-m');
        $periodo2 = $request->periodo2 ?? date('Y-m');
        $valor1 = $request->valor1 ?? 0.01;
        $valor2 = $request->valor2 ?? 999999.99;

        $despesas = DB::table('despesas')->whereBetween('periodo', [$periodo1, $periodo2])->whereBetween('valor', [$valor1, $valor2])->get();

        return view('filter.despesa', compact('periodo1', 'periodo2', 'valor1', 'valor2', 'despesas'));
    }

    public function gasto(Request $request)
    {
        // dd($request->all());
        $filter = $request->all();
        $periodo1 = $request->periodo1 ?? date('Y-m');
        $periodo2 = $request->periodo2 ?? date('Y-m');
        $credor = $request->credor ?? '%';
        $mp = $request->mp ?? '%';
        $valor1 = $request->valor1 ?? 0.01;
        $valor2 = $request->valor2 ?? 999999.99;
        $agrupador = $request->agrupador ?? '%';
        $localizador = $request->localizador ?? '%';
        $observacao = $request->observacao ?? '%';
        $observacao_pgto = $request->observacao_pgto ?? '%';


        if (is_null($request->pagoem1) && is_null($request->pagoem2)) {
            $pagoem1 = '';
            $pagoem2 = '';
        } else {
            $pagoem1 = $request->pagoem1 ?? '';
            $pagoem2 = $request->pagoem2 ?? '9999-12-31';
        }

        $gastos = DB::table('gastos')->join('despesas', 'despesas.id', '=', 'gastos.despesa_id')->whereBetween('despesas.periodo', [$periodo1, $periodo2])->where('gastos.credor', 'like', $credor)->whereBetween('gastos.valor', [$valor1, $valor2])->where('gastos.agrupador', 'like', $agrupador)->where('gastos.localizador', 'like', $localizador)->where('observacao', 'like', $observacao)->where('observacao_pgto', 'like', $observacao_pgto)->whereBetween('pagoem', [$pagoem1, $pagoem2])->where('gastos.mp', 'like', $mp)->select('gastos.*', 'despesas.descricao', 'despesas.periodo')->get();

        return view('filter.gasto', compact('periodo1', 'periodo2', 'credor', 'valor1', 'valor2', 'agrupador', 'localizador', 'gastos', 'pagoem1', 'pagoem2', 'mp', 'observacao', 'observacao_pgto', 'filter'));
    }

    public function payment(Request $request)
    {
        if (is_null($request->gastos) || sizeof($request->gastos) == 0) {
            return redirect()->back()->with('warning', 'Nenhum gasto selecionado.');
        }

        $gastos = DB::table('gastos')->join('despesas', 'despesas.id', '=', 'gastos.despesa_id')->whereIn('gastos.id', $request->gastos)->select('gastos.*', 'despesas.descricao', 'despesas.periodo')->get();

        $dataPgto = date('Y-m-d');
        return view('filter.gasto.payment', compact('gastos', 'dataPgto'));
    }

    public function pay(Request $request)
    {
        // dd($request->all());
        foreach ($request->get('gasto_id') as $gasto_id => $gasto) {
            $record = Gasto::find($gasto_id);
            $record->update([
                'pagoem' => $request->get('pagoem')[$gasto_id],
                'observacao_pgto' => $request->get('observacao_pgto')[$gasto_id],
            ]);
            $record->save();
        }

        return redirect()->route('filter.gasto')->with('success', 'Pagamentos efetuados.');
    }
}
