<?php

use App\Models\Receita;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recebimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Receita::class, 'receita_id')->required()->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('data')->required()->nullable(false);
            $table->decimal('valor', 8, 2)->required()->nullable(false);
            $table->longText('observacao')->nullable(true)->size(255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recebimentos');
    }
};
