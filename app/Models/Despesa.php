<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Despesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'periodo',
        'descricao',
        'valor',
    ];

    public function periodo(): BelongsTo
    {
        return $this->belongsTo(Periodo::class, 'periodo', 'periodo');
    }

    public function gastos(): HasMany
    {
        return $this->hasMany(Gasto::class);
    }

    public function totalGasto(): float
    {
        return round($this->gastos()->sum('valor'), 2);
    }

    public function totalAGastar(): float
    {
        return round($this->valor - $this->totalGasto(), 2);
    }

    public function totalPago(): float
    {
        return round($this->gastos()->whereNot('pagoem', '')->sum('valor'), 2);
    }

    public function totalAPagar(): float
    {
        return (float) round($this->totalGasto() - $this->totalPago(), 2);
    }
}
