<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recebimento extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'valor', 'observacao', 'receita_id'];

    public function receita(): BelongsTo
    {
        return $this->belongsTo(Receita::class);
    }
}
