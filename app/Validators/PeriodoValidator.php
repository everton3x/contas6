<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class PeriodoValidator
{
    public static function rules(): array
    {
        return  [
            'periodo' => 'required|date_format:Y-m',
        ];
    }

    public static function messages(): array
    {
        return [
            'periodo.required' => 'O campo Período deve ser preenchido.',
            'periodo.date_format' => 'Período em formato inválido.',
        ];
    }

    public static function validator(string $periodo): Validator
    {
        return FacadesValidator::make(['periodo' => $periodo], self::rules(), self::messages());
    }
}
