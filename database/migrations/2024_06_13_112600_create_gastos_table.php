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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Despesa::class, 'despesa_id')->required()->nullable(false)->min(1)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('gastoem')->required()->nullable(false);
            $table->longText('observacao')->nullable()->size(255);
            $table->decimal('valor', 8, 2)->required()->nullable(false);
            $table->longText('credor')->required()->nullable(false)->size(255);
            $table->longText('mp')->required()->nullable(false)->size(255);
            $table->date('vencimento')->nullable();
            $table->longText('agrupador')->nullable()->size(255);
            $table->longText('localizador')->nullable()->size(255);
            $table->date('pagoem')->required()->nullable();
            $table->longText('observacao_pgto')->nullable()->size(255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
