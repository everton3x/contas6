<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Receita extends Model
{
    use HasFactory;

    protected $fillable = [
        'periodo',
        'descricao',
        'devedor',
        'valor',
        'vencimento',
        'agrupador',
        'localizador'
    ];

    public function periodo(): BelongsTo
    {
        return $this->belongsTo(Periodo::class, 'periodo', 'periodo');
    }

    public function recebimentos(): HasMany
    {
        return $this->hasMany(Recebimento::class);
    }

    public function totalRecebido(): float
    {
        return $this->recebimentos()->sum('valor');
    }

    public function totalAReceber(): float
    {
        return $this->valor - $this->totalRecebido();
    }
}
