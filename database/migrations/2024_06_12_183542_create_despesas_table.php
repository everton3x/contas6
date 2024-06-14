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
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->string('periodo')->required()->nullable(false)->size(7);
            $table->longText('descricao')->required()->nullable(false)->size(255);
            $table->decimal('valor', 8, 2)->required()->nullable(false);
            $table->timestamps();
        });

        Schema::table('despesas', function (Blueprint $table) {
            $table->index(['periodo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};
