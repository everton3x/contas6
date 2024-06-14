<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class ReceitaValidator
{
    public static function rules(): array
    {
        $rules = [
            'descricao' => 'string|required|min:3|max:255',
            'devedor' => 'string|required|min:3|max:255',
            'valor' => 'decimal:0,2|required|min:0.01',
            'vencimento' => 'date|nullable',
            'agrupador' => 'string|nullable|max:255',
            'localizador' => 'string|nullable|max:255',
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
            'devedor.string' => 'O campo Devedor deve ser texto.',
            'devedor.required' => 'O campo Devedor deve ser preenchido.',
            'devedor.min' => 'O campo Devedor deve ter pelo menos 3 caracteres.',
            'devedor.max' => 'O campo Devedor deve ter no maximo 255 caracteres.',
            'valor.required' => 'O campo Valor deve ser preenchido.',
            'valor.min' => 'O campo Valor deve ser maior ou igual a 0,01.',
            'valor.decimal' => 'O campo Valor deve ser um número com 2 casas decimais no máximo.',
            'vencimento.date' => 'O campo Vencimento deve ser uma data.',
            'agrupador.max' => 'O campo Agrupador deve ter no maximo 255 caracteres.',
            'agrupador.string' => 'O campo Agrupador deve ser texto.',
            'localizador.max' => 'O campo Localizador deve ter no maximo 255 caracteres.',
            'localizador.string' => 'O campo Localizador deve ser texto.',
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
            'id' => 'integer|required|exists:receitas,id',
        ]);
        $messages = array_merge(self::messages(), [
            'id.exists' => 'O campo ID deve existir na tabela de Receitas.',
            'id.required' => 'O campo ID deve ser preenchido.',
            'id.integer' => 'O campo ID deve ser um inteiro.',
        ]);
        return FacadesValidator::make($request->all(), $rules, $messages);
    }
}
