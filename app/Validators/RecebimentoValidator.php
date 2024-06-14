<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class RecebimentoValidator
{
    public static function rules(): array
    {
        $rules = [
            'receita_id' => 'integer|required|min:1|exists:receitas,id',
            'valor' => 'decimal:0,2|required|min:0.01',
            'data' => 'date|required',
            'observacao' => 'string|nullable|max:255',
        ];

        return $rules;
    }

    public static function messages(): array
    {
        $messages = [
            'receita_id.required' => 'Receita obrigatória.',
            'receita_id.integer' => 'Receita não é número inteiro.',
            'receita_id.exists' => 'Receita não existe.',
            'receita_id.min' => 'Receita deve ser maior que zero.',
            'valor.required' => 'Valor obrigatório.',
            'valor.decimal' => 'Valor não é número.',
            'valor.min' => 'Valor deve ser maior que zero.',
            'data.required' => 'Data obrigatória.',
            'data.date' => 'Data inválida.',
            'observacao.string' => 'Observação não é texto.',
            'observacao.max' => 'Observação deve ser menor que 255 caracteres.',
        ];
        return $messages;
    }

    public static function validator(Request $request): Validator
    {
        return FacadesValidator::make($request->all(), self::rules(), self::messages());
    }

    public static function validatorUpdate(Request $request): Validator
    {
        $rules = array_merge(self::rules(), [
            'id' => 'integer|required|min:1|exists:recebimentos,id',
        ]);
        $messages = array_merge(self::messages(), [
            'id.required' => 'Recebimento obrigatório.',
            'id.integer' => 'Recebimento não é número inteiro.',
            'id.exists' => 'Recebimento não existe.',
            'id.min' => 'Recebimento deve ser maior que zero.',
        ]);
        return FacadesValidator::make($request->all(), $rules, $messages);
    }
}
