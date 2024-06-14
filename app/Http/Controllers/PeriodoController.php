<?php

namespace App\Http\Controllers;

use App\Helpers\PeriodoHelper;
use App\Models\Despesa;
use App\Models\Gasto;
use App\Models\Periodo;
use App\Models\Recebimento;
use App\Models\Receita;
use App\Validators\PeriodoValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class PeriodoController extends Controller
{
    public function select(Request $request, $periodo = null)
    {
        if(is_null($periodo)) {
            $current = $request->get('periodo');
        }else{
            $current = $periodo;
        }
        $validator = PeriodoValidator::validator($current);
        if($validator->fails()) {
            throw new \Exception($validator->errors());
        }
        session(['periodo' => $current]);
        return redirect()->route('dashboard');
    }

    public function next()
    {
        $current = session('periodo');
        $next = PeriodoHelper::next($current);
        $validator = PeriodoValidator::validator($next);
        if($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
        session(['periodo' => $next]);
        return redirect()->route('dashboard');
    }

    public function previous()
    {
        $current = session('periodo');
        $previous = PeriodoHelper::previous($current);
        $validator = PeriodoValidator::validator($previous);
        if($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
        session(['periodo' => $previous]);
        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        $periodo = session('periodo') ?? date('Y-m');
        $receitas = Receita::where('periodo', $periodo)->orderBy('descricao')->get();
        $despesas = Despesa::where('periodo', $periodo)->orderBy('descricao')->get();
        $resultadoMes = resultado_periodo($periodo);
        $resultadoAnterior = resultado_acumulado($previous = PeriodoHelper::previous($periodo));
        if(is_opened($previous) && ($resultadoAnterior > 0)) {
            $resultadoAnterior = 0;
        }
        $resultadoAcumulado = round($resultadoAnterior + $resultadoMes, 2);

        return view('dashboard', compact('receitas', 'despesas', 'periodo', 'resultadoMes', 'resultadoAnterior', 'resultadoAcumulado'));
    }

    public function manage()
    {
        return view('periodo.manage');
    }

    public function close($periodo)
    {
        if(is_closed($periodo)){
            $errors = new MessageBag(['periodo' => 'O período já está fechado.']);
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // testa se tem valores a pagar no período
        $a_pagar = Periodo::where('periodo', $periodo)->first()->gastos->whereNull('pagoem')->count();
        if($a_pagar > 0) {
            $errors = new MessageBag(['periodo' => 'O período possui valores a pagar.']);
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // iguala o saldo da receita prevista com o recebido
        $receitas = Receita::where('periodo', $periodo)->get();
        foreach ($receitas as $receita) {
            if($receita->totalRecebido() != $receita->valor) {
                $receita->valor = $receita->totalRecebido();
                $receita->save();
            }
        }

        // iguala o saldo da despesa prevista com o gasto
        $despesas = Despesa::where('periodo', $periodo)->get();
        foreach ($despesas as $despesa) {
            if($despesa->totalGasto() != $despesa->valor) {
                $despesa->valor = $despesa->totalGasto();
                $despesa->save();
            }
        }

        $periodo = Periodo::where('periodo', $periodo)->first();
        $periodo->fechado = true;
        $periodo->save();
        return redirect()->back()->with('success', 'Período fechado.');
    }

    public function open($periodo)
    {
        if(is_opened($periodo)){
            $errors = new MessageBag(['periodo' => 'O período já está aberto.']);
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $periodo = Periodo::where('periodo', $periodo)->first();
        $periodo->fechado = false;
        $periodo->save();
        return redirect()->back()->with('success', 'Período aberto.');
    }

    public function reconcile(Request $request)
    {
        $periodo = $request->get('periodo');
        if(is_null($periodo)) {
            $periodo = session('periodo') ?? date('Y-m');
        }
        $disponivel = $request->get('disponivel');

        $aReceber = 0.0;
        foreach (Receita::where('periodo', '<=', $periodo)->get() as $receita) {
            $aReceber += $receita->totalAReceber();
        }

        $aGastar = 0.0;
        $aPagar = 0.0;
        foreach (Despesa::where('periodo', '<=', $periodo)->get() as $despesa) {
            $aGastar += $despesa->totalAGastar();
            $aPagar += $despesa->totalAPagar();
        }

        $resultado = resultado_acumulado($periodo);
        $resultadoCalculado = round($disponivel + $aReceber - $aGastar - $aPagar, 2);
        $diferenca = round($resultado - $resultadoCalculado, 2);
        return view('periodo.reconcile', compact('periodo', 'aReceber', 'aGastar', 'aPagar', 'resultado', 'resultadoCalculado', 'diferenca', 'disponivel'));
    }

    public function reconcileAdjust(Request $request)
    {
        $periodo = $request->get('periodo');
        $diferenca = $request->get('diferenca');
        if($diferenca > 0.0){
            $despesa = Despesa::create([
                'periodo' => $periodo,
                'descricao' => 'Ajuste por conciliação',
                'valor' => $diferenca
            ]);
            $despesa->save();
            $gasto = Gasto::create([
                'despesa_id' => $despesa->id,
                'gastoem' => date('Y-m-d'),
                'valor' => $diferenca,
                'credor' => 'Ajustes',
                'mp' => 'Ajustes',
                'agrupador' => 'Ajustes',
                'localizador' => 'Ajustes',
                'pagoem' => date('Y-m-d'),
            ]);
            $gasto->save();
        }else{
            $diferenca = round($diferenca * -1.0, 2);
            $receita = Receita::create([
                'periodo' => $periodo,
                'descricao' => 'Ajuste por conciliação',
                'devedor' => 'Ajustes',
                'valor' => $diferenca,
                'agrupador' => 'Ajustes',
                'localizador' => 'Ajustes',
            ]);
            $receita->save();
            $recebimento = Recebimento::create([
                'receita_id' => $receita->id,
                'valor' => $diferenca,
                'data' => date('Y-m-d'),
            ]);
            $recebimento->save();
        }
        return redirect()->back()->with('success', 'Ajuste efetuado.');
    }

}
