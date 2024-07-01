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

        $receitas = DB::select(sprintf('
                                select *
                                from "receitas"
                                where
                                    "periodo" between \'%s\' and \'%s\'
                                    and "devedor" like \'%s\'
                                    and "valor" between %d and %d
                                    and ("agrupador" like \'%s\' or "agrupador" is null)
                                    and ("localizador" like \'%s\' or "localizador" is null)
                                ', $periodo1, $periodo2, $devedor, $valor1, $valor2, $agrupador, $localizador
                            ));

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
        $filter = $request->all();
        // dd($filter);
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
        $naopagos = $request->naopagos ?? '';

        if($naopagos == 'on'){
            $pagoem1 = null;
            $pagoem2 = null;
        }elseif (is_null($request->pagoem1) && is_null($request->pagoem2)) {
            $pagoem1 = '';
            $pagoem2 = '9999-12-31';
        } else {
            $pagoem1 = $request->pagoem1 ?? '';
            $pagoem2 = $request->pagoem2 ?? '';
        }

        $gastos = DB::select(sprintf(
            'select "gastos".*, "despesas"."descricao", "despesas"."periodo"
            from "gastos"
            inner join "despesas" on "despesas"."id" = "gastos"."despesa_id"
            where
                "despesas"."periodo" between \'%s\' and \'%s\'
                and "gastos"."credor" like \'%s\'
                and "gastos"."valor" between %d and %d
                and ("gastos"."agrupador" like \'%s\' or "gastos"."agrupador" IS NULL)
                and ("gastos"."localizador" like \'%s\' or "gastos"."localizador" IS NULL)
                and ("observacao" like \'%s\' or "observacao" IS NULL)
                and ("observacao_pgto" like \'%s\' or "observacao_pgto" is null)
                and ("pagoem" between \'%s\' and \'%s\' or "pagoem" is null)
                and "gastos"."mp" like \'%s\' order by "gastos"."valor" asc',
            $periodo1, $periodo2, $credor, $valor1, $valor2, $agrupador, $localizador, $observacao, $observacao_pgto, $pagoem1, $pagoem2, $mp));

        return view('filter.gasto', compact('periodo1', 'periodo2', 'credor', 'valor1', 'valor2', 'agrupador', 'localizador', 'gastos', 'pagoem1', 'pagoem2', 'mp', 'observacao', 'observacao_pgto', 'filter', 'naopagos'));
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
