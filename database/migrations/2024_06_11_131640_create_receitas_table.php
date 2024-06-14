<?php

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
        Schema::create('receitas', function (Blueprint $table) {
            $table->id();
            $table->string('periodo')->required()->nullable(false)->size(7);
            $table->longText('descricao')->required()->nullable(false)->size(255);
            $table->longText('devedor')->required()->nullable(false)->size(255);
            $table->decimal('valor', 8, 2)->required()->nullable(false);
            $table->date('vencimento')->nullable();
            $table->longText('agrupador')->nullable()->size(255);
            $table->longText('localizador')->nullable()->size(255);
            $table->timestamps();
        });

        Schema::table('receitas', function (Blueprint $table) {
            $table->index(['periodo', 'devedor', 'agrupador', 'localizador']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receitas');
    }
};
