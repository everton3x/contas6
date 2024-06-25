<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Gasto;
use App\Validators\GastoValidator;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class GastoController extends Controller
{
    public function create($despesa_id)
    {
        $despesa = Despesa::find($despesa_id);
        return view('gasto.create', ['despesa' => $despesa]);
    }

    public function store(Request $request)
    {
        $validator = GastoValidator::validator($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $record = Gasto::create($validator->validated());
        $record->save();

        $despesa = Despesa::find($record->despesa_id);
        if($despesa->valor < $despesa->totalGasto()) {
            $despesa->update(['valor' => $despesa->totalGasto()]);
        }

        return redirect()->route('despesa.show', ['despesa_id' => $record->despesa_id])->with('success', 'Gasto criado.');
    }

    public function edit($despesa_id, $id)
    {
        $despesa = Despesa::find($despesa_id);
        $gasto = Gasto::find($id);
        return view('gasto.edit', ['despesa' => $despesa, 'gasto' => $gasto]);
    }

    public function update(Request $request)
    {
        $validator = GastoValidator::validatorUpdate($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $record = Gasto::find($request->id);
        $record->update($validator->validated());

        $despesa = Despesa::find($record->despesa_id);
        if($despesa->valor < $despesa->totalGasto()) {
            $despesa->update(['valor' => $despesa->totalGasto()]);
        }

        return redirect()->route('despesa.show', ['despesa_id' => $record->despesa_id])->with('success', 'Gasto atualizado.');
    }

    public function destroy($despesa_id, $gasto_id)
    {
        $record = Gasto::find($gasto_id);
        if(is_null($record)) {
            return redirect()->route('despesa.show', ['despesa_id' => $despesa_id])->with('error', 'Gasto não encontrado.');
        }
        $record->delete();
        return redirect()->route('despesa.show', ['despesa_id' => $record->despesa_id])->with('success', 'Gasto apagado.');
    }

    public function payment($despesa_id, $id)
    {
        $despesa = Despesa::find($despesa_id);
        $gasto = Gasto::find($id);
        return view('gasto.payment', ['despesa' => $despesa, 'gasto' => $gasto]);
    }

    public function pay(Request $request)
    {
        $validator = GastoValidator::validatorPay($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $record = Gasto::find($request->id);
        $record->update($validator->validated());

        return redirect()->route('despesa.show', ['despesa_id' => $record->despesa_id])->with('success', 'Pagamento realizado.');
    }

    public function transpose(Request $request, $despesa_id, $gasto_id, $periodo = null) {
        if($request->periodo) $periodo = $request->periodo;
        if(is_null($periodo)) {
            $periodo = date('Y-m');
        }
        $despesa = Despesa::find($despesa_id);
        $gasto = Gasto::find($gasto_id);
        $target = Despesa::where('periodo', $periodo)->get();
        return view('gasto.transpose', compact('despesa', 'gasto', 'periodo', 'target'));
    }

    public function transposeStore(Request $request) {
        $despesa_id = $request->despesa_id;
        $gasto_id = $request->gasto_id;
        $gasto = Gasto::find($gasto_id);
        $gasto->update(['despesa_id' => $despesa_id]);
        return redirect()->route('despesa.show', ['despesa_id' => $despesa_id])->with('success', 'Transposição concluída.');
    }
}
