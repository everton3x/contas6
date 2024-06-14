<?php

namespace App\Http\Controllers;

use App\Helpers\PeriodoHelper;
use App\Models\Receita;
use App\Validators\ReceitaValidator;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class ReceitaController extends Controller
{
    public function create()
    {
        return view('receita.create');
    }

    public function store(Request $request)
    {
        if(is_closed($request->get('periodo'))){
            $errors = new MessageBag(['periodo' => 'Período fechado não pode receber lançamentos.']);
            return redirect()->back()->withErrors($errors)->withInput();
        }
        $validator = ReceitaValidator::validator($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $record = Receita::create($validator->validated());
        $record->save();
        return redirect()->route('receita.show', ['receita_id' => $record->id])->with('success', 'Receita criada.');
    }

    public function show($receita_id)
    {
        $record = Receita::find($receita_id);
        return view('receita.show', ['receita' => $record]);
    }

    public function edit($receita_id)
    {
        $receita = Receita::find($receita_id);
        return view('receita.edit', ['receita' => $receita]);
    }

    public function update(Request $request)
    {
        if(is_closed($request->get('periodo'))){
            $errors = new MessageBag(['periodo' => 'Período fechado não pode receber lançamentos.']);
            return redirect()->back()->withErrors($errors)->withInput();
        }
        $validator = ReceitaValidator::validatorUpdate($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $record = Receita::find($request->id);
        $record->update($validator->validated());

        return redirect()->route('receita.show', ['receita_id' => $record->id])->with('success', 'Receita atualizada.');
    }

    public function destroy($receita_id)
    {
        $record = Receita::find($receita_id);
        if(is_null($record)) {
            return redirect()->route('dashboard')->with('error', 'Receita não encontrada.');
        }
        if(is_closed($record->periodo)){
            $errors = new MessageBag(['periodo' => 'Período fechado não pode receber lançamentos.']);
            return redirect()->back()->withErrors($errors)->withInput();
        }
        $record->delete();
        return redirect()->route('dashboard')->with('success', 'Receita apagada.');
    }

    public function repeat()
    {
        return view('receita.repeat');
    }

    public function repeatConfirm(Request $request)
    {
        $receitas = [];
        $parcelas = $request->get('parcelas');
        $periodo = $request->get('periodo');
        $descricao = $request->get('descricao');
        $devedor = $request->get('devedor');
        $valor = $request->get('valor');
        $vencimento = $request->get('vencimento');
        $agrupador = $request->get('agrupador');
        $localizador = $request->get('localizador');
        for($parcela = 1; $parcela <= $parcelas; $parcela++) {
            $receitas[$parcela] = [
                'parcela' => $parcela,
                'periodo' => $periodo,
                'descricao' => $descricao,
                'devedor' => $devedor,
                'valor' => $valor,
                'vencimento' => $vencimento,
                'agrupador' => $agrupador,
                'localizador' => $localizador
            ];
            $periodo = PeriodoHelper::next($periodo);
            $vencimento = PeriodoHelper::nextVencimento($vencimento);
        }

        return view('receita.repeat.confirm', ['receitas' => $receitas]);
    }

    public function repeatStore(Request $request)
    {
        $firstId = null;
        $parcelas = sizeof($request->get('periodo'));
        for ($parcela = 1; $parcela <= $parcelas; $parcela++) {
            $receita = Request::create(route('receita.repeat.store'), 'POST', [
                'periodo' => $request->get('periodo')[$parcela],
                'descricao' => $request->get('descricao')[$parcela],
                'devedor' => $request->get('devedor')[$parcela],
                'valor' => $request->get('valor')[$parcela],
                'vencimento' => $request->get('vencimento')[$parcela],
                'agrupador' => $request->get('agrupador')[$parcela],
                'localizador' => $request->get('localizador')[$parcela]
            ]);

            $validator = ReceitaValidator::validator($receita);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $record = Receita::create($validator->validated());
            $record->save();
            if(is_null($firstId)) {
                $firstId = $record->id;
            }
        }
        return redirect()->route('receita.show', ['receita_id' => $firstId])->with('success', 'Receitas criadas.');
    }


    public function parcel()
    {
        return view('receita.parcel');
    }

    public function parcelConfirm(Request $request)
    {
        $receitas = [];
        $parcelas = $request->get('parcelas');
        $periodo = $request->get('periodo');
        $descricao = $request->get('descricao');
        $devedor = $request->get('devedor');
        $valor = $request->get('valor');
        $tipoValor = $request->get('tipo_valor');
        $vencimento = $request->get('vencimento');
        $agrupador = $request->get('agrupador');
        $localizador = $request->get('localizador');
        $media = round($valor / $parcelas, 2);
        $saldo = $valor;

        for($parcela = 1; $parcela <= $parcelas; $parcela++) {
            switch($tipoValor) {
                case 'total':
                    if($parcela < $parcelas) {
                        $valor = $media;
                        $saldo -= $media;
                    }else{
                        $valor = $saldo;
                    }
                    break;
                case 'parcela':
                    // $valor já tem o valor da parcela
                    break;
                default:
                    throw new \Exception('Tipo de valor inválido.');
            }
            $receitas[$parcela] = [
                'parcela' => $parcela,
                'periodo' => $periodo,
                'descricao' => sprintf('%s (parcela %d de %d)', $descricao, $parcela, $parcelas),
                'devedor' => $devedor,
                'valor' => $valor,
                'vencimento' => $vencimento,
                'agrupador' => $agrupador,
                'localizador' => $localizador
            ];
            $periodo = PeriodoHelper::next($periodo);
            $vencimento = PeriodoHelper::nextVencimento($vencimento);
        }

        return view('receita.parcel.confirm', ['receitas' => $receitas]);
    }

    public function parcelStore(Request $request)
    {
        $firstId = null;
        $parcelas = sizeof($request->get('periodo'));
        for ($parcela = 1; $parcela <= $parcelas; $parcela++) {
            $receita = Request::create(route('receita.repeat.store'), 'POST', [
                'periodo' => $request->get('periodo')[$parcela],
                'descricao' => $request->get('descricao')[$parcela],
                'devedor' => $request->get('devedor')[$parcela],
                'valor' => $request->get('valor')[$parcela],
                'vencimento' => $request->get('vencimento')[$parcela],
                'agrupador' => $request->get('agrupador')[$parcela],
                'localizador' => $request->get('localizador')[$parcela]
            ]);

            $validator = ReceitaValidator::validator($receita);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $record = Receita::create($validator->validated());
            $record->save();
            if(is_null($firstId)) {
                $firstId = $record->id;
            }
        }
        return redirect()->route('receita.show', ['receita_id' => $firstId])->with('success', 'Parcelas da receita criadas.');
    }

    public function adjustPrevisao($receita_id)
    {
        $receita = Receita::find($receita_id);
        if($receita->valor !== $receita->totalRecebido()) {
            $receita->valor = $receita->totalRecebido();
            $receita->save();
        }
        return redirect()->route('receita.show', ['receita_id' => $receita_id])->with('success', 'Previsão ajustada.');
    }
}
