<?php

namespace App\Http\Controllers;

use App\Helpers\PeriodoHelper;
use App\Models\Despesa;
use App\Models\Gasto;
use App\Validators\DespesaValidator;
use App\Validators\GastoValidator;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class DespesaController extends Controller
{
    public function create()
    {
        return view('despesa.create');
    }

    public function store(Request $request)
    {
        if(is_closed($request->get('periodo'))){
            $errors = new MessageBag(['periodo' => 'Período fechado não pode receber lançamentos.']);
            return redirect()->back()->withErrors($errors)->withInput();
        }
        $validator = DespesaValidator::validator($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $record = Despesa::create($validator->validated());
        $record->save();
        return redirect()->route('despesa.show', ['despesa_id' => $record->id])->with('success', 'Despesa criada.');
    }

    public function show($despesa_id)
    {
        $record = Despesa::find($despesa_id);
        return view('despesa.show', ['despesa' => $record]);
    }

    public function edit($despesa_id)
    {
        $despesa = Despesa::find($despesa_id);
        return view('despesa.edit', ['despesa' => $despesa]);
    }

    public function update(Request $request)
    {
        if(is_closed($request->get('periodo'))){
            $errors = new MessageBag(['periodo' => 'Período fechado não pode receber lançamentos.']);
            return redirect()->back()->withErrors($errors)->withInput();
        }
        $validator = DespesaValidator::validatorUpdate($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $record = Despesa::find($request->id);
        $record->update($validator->validated());

        return redirect()->route('despesa.show', ['despesa_id' => $record->id])->with('success', 'Despesa atualizada.');
    }

    public function destroy($despesa_id)
    {
        $record = Despesa::find($despesa_id);
        if(is_null($record)) {
            return redirect()->route('dashboard')->with('error', 'Despesa não encontrada.');
        }
        if(is_closed($record->periodo)){
            $errors = new MessageBag(['periodo' => 'Período fechado não pode receber lançamentos.']);
            return redirect()->back()->withErrors($errors)->withInput();
        }
        $record->delete();
        return redirect()->route('dashboard')->with('success', 'Despesa apagada.');
    }

    public function repeat()
    {
        return view('despesa.repeat');
    }

    public function repeatConfirm(Request $request)
    {
        $despesas = [];
        $parcelas = $request->get('parcelas');

        $periodo = $request->get('periodo');
        $descricao = $request->get('descricao');
        $valor = $request->get('valor');

        $gastar = $request->get('gastar');
        $gastoem = $request->get('gastoem');
        $observacao = $request->get('observacao');
        $credor = $request->get('credor');
        $mp = $request->get('mp');
        $vencimento = $request->get('vencimento');
        $agrupador = $request->get('agrupador');
        $localizador = $request->get('localizador');
        for($parcela = 1; $parcela <= $parcelas; $parcela++) {
            $despesas[$parcela] = [
                'parcela' => $parcela,
                'periodo' => $periodo,
                'descricao' => $descricao,
                'valor' => $valor,
                'gastar' => $gastar,
                'gastoem' => $gastoem,
                'observacao' => $observacao,
                'credor' => $credor,
                'mp' => $mp,
                'vencimento' => $vencimento,
                'agrupador' => $agrupador,
                'localizador' => $localizador
            ];
            $periodo = PeriodoHelper::next($periodo);
            $vencimento = PeriodoHelper::nextVencimento($vencimento);
        }

        return view('despesa.repeat.confirm', ['despesas' => $despesas]);
    }

    public function repeatStore(Request $request)
    {
        $firstId = null;
        $parcelas = sizeof($request->get('periodo'));
        $gastar = (bool) $request->get('gastar');

        for ($parcela = 1; $parcela <= $parcelas; $parcela++) {
            $despesa = Request::create(route('despesa.store'), 'POST', [
                'periodo' => $request->get('periodo')[$parcela],
                'descricao' => $request->get('descricao')[$parcela],
                'valor' => $request->get('valor')[$parcela],
            ]);

            $validator = DespesaValidator::validator($despesa);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $record = Despesa::create($validator->validated());
            $record->save();
            if(is_null($firstId)) {
                $firstId = $record->id;
            }

            if($gastar) {
                $gasto = Request::create(route('despesa.store'), 'POST', [
                    'despesa_id' => $record->id,
                    'valor' => $request->get('valor')[$parcela],
                    'gastoem' => $request->get('gastoem')[$parcela],
                    'observacao' => $request->get('observacao')[$parcela],
                    'credor' => $request->get('credor')[$parcela],
                    'mp' => $request->get('mp')[$parcela],
                    'vencimento' => $request->get('vencimento')[$parcela],
                    'agrupador' => $request->get('agrupador')[$parcela],
                    'localizador' => $request->get('localizador')[$parcela]
                ]);

                $validator = GastoValidator::validator($gasto);
                if ($validator->fails()) {
                    // @TODO Isso dispara uma exceção porque o redirect é feito com GET, mas a rota só aceita POST.
                    return redirect()->back()->withErrors($validator->errors())->withInput();
                }

                $record = Gasto::create($validator->validated());
                $record->save();
            }
        }
        return redirect()->route('despesa.show', ['despesa_id' => $firstId])->with('success', 'Despesas criadas.');
    }

    public function parcel()
    {
        return view('despesa.parcel');
    }

    public function parcelConfirm(Request $request)
    {
        $despesas = [];
        $parcelas = $request->get('parcelas');

        $periodo = $request->get('periodo');
        $descricao = $request->get('descricao');
        $valor = $request->get('valor');
        $tipoValor = $request->get('tipo_valor');
        $gastoem = $request->get('gastoem');
        $observacao = $request->get('observacao');
        $credor = $request->get('credor');
        $mp = $request->get('mp');
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
            $despesas[$parcela] = [
                'parcela' => $parcela,
                'periodo' => $periodo,
                'descricao' => sprintf('%s (parcela %d de %d)', $descricao, $parcela, $parcelas),
                'valor' => $valor,
                'gastoem' => $gastoem,
                'observacao' => $observacao,
                'credor' => $credor,
                'mp' => $mp,
                'vencimento' => $vencimento,
                'agrupador' => $agrupador,
                'localizador' => $localizador
            ];
            $periodo = PeriodoHelper::next($periodo);
            $vencimento = PeriodoHelper::nextVencimento($vencimento);
        }

        return view('despesa.parcel.confirm', ['despesas' => $despesas]);
    }

    public function parcelStore(Request $request)
    {
        $firstId = null;
        $parcelas = sizeof($request->get('periodo'));

        for ($parcela = 1; $parcela <= $parcelas; $parcela++) {
            $despesa = Request::create(route('despesa.store'), 'POST', [
                'periodo' => $request->get('periodo')[$parcela],
                'descricao' => $request->get('descricao')[$parcela],
                'valor' => $request->get('valor')[$parcela],
            ]);

            $validator = DespesaValidator::validator($despesa);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $record = Despesa::create($validator->validated());
            $record->save();
            if(is_null($firstId)) {
                $firstId = $record->id;
            }

            $gasto = Request::create(route('despesa.store'), 'POST', [
                'despesa_id' => $record->id,
                'valor' => $request->get('valor')[$parcela],
                'gastoem' => $request->get('gastoem')[$parcela],
                'observacao' => $request->get('observacao')[$parcela],
                'credor' => $request->get('credor')[$parcela],
                'mp' => $request->get('mp')[$parcela],
                'vencimento' => $request->get('vencimento')[$parcela],
                'agrupador' => $request->get('agrupador')[$parcela],
                'localizador' => $request->get('localizador')[$parcela]
            ]);

            $validator = GastoValidator::validator($gasto);
            if ($validator->fails()) {
                // @TODO Isso dispara uma exceção porque o redirect é feito com GET, mas a rota só aceita POST.
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $record = Gasto::create($validator->validated());
            $record->save();

        }
        return redirect()->route('despesa.show', ['despesa_id' => $firstId])->with('success', 'Parcelamento de despesa criado.');
    }

    public function adjustPrevisao($despesa_id)
    {
        $despesa = Despesa::find($despesa_id);
        if($despesa->valor !== $despesa->totalGasto()) {
            $despesa->valor = $despesa->totalGasto();
            $despesa->save();
        }
        return redirect()->route('despesa.show', ['despesa_id' => $despesa_id])->with('success', 'Previsão ajustada.');
    }
}
