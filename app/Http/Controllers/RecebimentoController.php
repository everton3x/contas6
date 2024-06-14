<?php

namespace App\Http\Controllers;

use App\Models\Recebimento;
use App\Models\Receita;
use App\Validators\RecebimentoValidator;
use Illuminate\Http\Request;

class RecebimentoController extends Controller
{
    public function create($receita_id)
    {
        $receita = Receita::find($receita_id);
        return view('recebimento.create', ['receita' => $receita]);
    }

    public function store(Request $request)
    {
        $validator = RecebimentoValidator::validator($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $record = Recebimento::create($validator->validated());
        $record->save();

        $receita = Receita::find($record->receita_id);
        if($receita->valor < $receita->totalRecebido()) {
            $receita->update(['valor' => $receita->totalRecebido()]);
        }

        return redirect()->route('receita.show', ['receita_id' => $record->receita_id])->with('success', 'Recebimento criado.');
    }

    public function edit($receita_id, $id)
    {
        $receita = Receita::find($receita_id);
        $recebimento = Recebimento::find($id);
        return view('recebimento.edit', ['receita' => $receita, 'recebimento' => $recebimento]);
    }

    public function update(Request $request)
    {
        $validator = RecebimentoValidator::validatorUpdate($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $record = Recebimento::find($request->id);
        $record->update($validator->validated());

        $receita = Receita::find($record->receita_id);
        if($receita->valor < $receita->totalRecebido()) {
            $receita->update(['valor' => $receita->totalRecebido()]);
        }

        return redirect()->route('receita.show', ['receita_id' => $record->receita_id])->with('success', 'Recebimento atualizado.');
    }

    public function destroy($receita_id, $recebimento_id)
    {
        $record = Recebimento::find($recebimento_id);
        if(is_null($record)) {
            return redirect()->route('receita.show', ['receita_id' => $receita_id])->with('error', 'Recebimento não encontrado.');
        }
        $record->delete();
        return redirect()->route('receita.show', ['receita_id' => $record->receita_id])->with('success', 'Recebimento apagado.');
    }

}
