<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class DespesaValidator
{
    public static function rules(): array
    {
        $rules = [
            'descricao' => 'string|required|min:3|max:255',
            'valor' => 'decimal:0,2|required|min:0.01',
        ];

        $rules = array_merge($rules, PeriodoValidator::rules());

        return $rules;
    }

    public static function messages(): array
    {
        $messages = [
            'descricao.string' => 'O campo Descricão deve ser texto.',
            'descricao.required' => 'O campo Descricão deve ser preenchido.',
            'descricao.min' => 'O campo Descricão deve ter pelo menos 3 caracteres.',
            'descricao.max' => 'O campo Descricão deve ter no maximo 255 caracteres.',
            'valor.required' => 'O campo Valor deve ser preenchido.',
            'valor.min' => 'O campo Valor deve ser maior ou igual a 0,01.',
            'valor.decimal' => 'O campo Valor deve ser um número com 2 casas decimais no máximo.',
        ];
        $messages = array_merge($messages, PeriodoValidator::messages());
        return $messages;
    }

    public static function validator(Request $request): Validator
    {
        return FacadesValidator::make($request->all(), self::rules(), self::messages());
    }

    public static function validatorUpdate(Request $request): Validator
    {
        $rules = array_merge(self::rules(), [
            'id' => 'integer|required|exists:despesas,id',
        ]);
        $messages = array_merge(self::messages(), [
            'id.exists' => 'O campo ID deve existir na tabela de Receitas.',
            'id.required' => 'O campo ID deve ser preenchido.',
            'id.integer' => 'O campo ID deve ser um inteiro.',
        ]);
        return FacadesValidator::make($request->all(), $rules, $messages);
    }
}
