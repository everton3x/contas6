<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class GastoValidator
{
    public static function rules(): array
    {
        $rules = [
            'despesa_id' => 'integer|required|min:1|exists:despesas,id',
            'valor' => 'decimal:0,2|required|min:0.01',
            'gastoem' => 'date|required',
            'observacao' => 'string|nullable|max:255',
            'credor' => 'string|required|min:3|max:255',
            'mp' => 'string|required|min:3|max:255',
            'vencimento' => 'date|nullable',
            'agrupador' => 'string|nullable|max:255',
            'localizador' => 'string|nullable|max:255',
            'pagoem' => 'date|nullable',
            'observacao_pgto' => 'string|nullable|max:255',
        ];

        return $rules;
    }

    public static function messages(): array
    {
        $messages = [
            'despesa_id.required' => 'Despesa obrigatória.',
            'despesa_id.integer' => 'Despesa não é número inteiro.',
            'despesa_id.exists' => 'Despesa não existe.',
            'despesa_id.min' => 'Despesa deve ser maior que zero.',
            'valor.required' => 'Valor obrigatório.',
            'valor.min' => 'Valor deve ser maior que zero.',
            'gastoem.required' => 'Data obrigatória.',
            'observacao.max' => 'Observação deve ter no maúximo 255 caracteres.',
            'credor.required' => 'Credor obrigatório.',
            'credor.min' => 'Credor deve ter pelo menos 3 caracteres.',
            'credor.max' => 'Credor deve ter no maúximo 255 caracteres.',
            'mp.required' => 'MP obrigatório.',
            'mp.min' => 'MP deve ter pelo menos 3 caracteres.',
            'mp.max' => 'MP deve ter no maúximo 255 caracteres.',
            'observacao_pgto.max' => 'Observação deve ter no maúximo 255 caracteres.',
            'observacao.max' => 'Observação deve ter no maúximo 255 caracteres.',
            'agrupador.max' => 'Agrupador deve ter no maúximo 255 caracteres.',
            'localizador.max' => 'Localizador deve ter no maúximo 255 caracteres.',
            'vencimento.required' => 'Data obrigatória.',
            'vencimento.date' => 'Data deve ser uma data.',
            'pagoem.date' => 'Data deve ser uma data.',

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
            'id' => 'integer|required|min:1|exists:gastos,id',
        ]);
        $messages = array_merge(self::messages(), [
            'id.required' => 'Gasto obrigatório.',
            'id.integer' => 'Gasto não é número inteiro.',
            'id.exists' => 'Gasto não existe.',
            'id.min' => 'Gasto deve ser maior que zero.',
        ]);
        return FacadesValidator::make($request->all(), $rules, $messages);
    }

    public static function validatorPay(Request $request): Validator
    {
        $rules = array_merge(self::rules(), [
            'id' => 'integer|required|min:1|exists:gastos,id',
        ]);
        unset($rules['despesa_id']);
        unset($rules['valor']);
        unset($rules['gastoem']);
        unset($rules['observacao']);
        unset($rules['credor']);
        unset($rules['mp']);
        unset($rules['vencimento']);
        unset($rules['agrupador']);
        unset($rules['localizador']);
        $messages = array_merge(self::messages(), [
            'id.required' => 'Gasto obrigatório.',
            'id.integer' => 'Gasto não é número inteiro.',
            'id.exists' => 'Gasto não existe.',
            'id.min' => 'Gasto deve ser maior que zero.',
        ]);
        return FacadesValidator::make($request->all(), $rules, $messages);
    }
}
