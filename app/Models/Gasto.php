<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gasto extends Model
{
    use HasFactory;

    protected $fillable = ['despesa_id', 'gastoem', 'observacao', 'valor', 'credor', 'mp', 'vencimento', 'agrupador', 'localizador', 'pagoem', 'observacao_pgto'];

    public function despesa(): BelongsTo
    {
        return $this->belongsTo(Despesa::class);
    }
}
