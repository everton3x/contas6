<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $fillable = [
        'periodo',
        'fechado',
    ];

    public function receitas()
    {
        return $this->hasMany(Receita::class, 'periodo', 'periodo');
    }

    public function despesas()
    {
        return $this->hasMany(Despesa::class, 'periodo', 'periodo');
    }

    public function gastos()
    {
        return $this->hasManyThrough(Gasto::class, Despesa::class, 'periodo', 'despesa_id', 'periodo', 'id');
    }

}
