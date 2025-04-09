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
        Schema::create('impresora_historicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('impresora_id')->constrained()->onDelete('cascade');
            $table->date('fecha');
            $table->unsignedInteger('paginas'); // Total acumulado de páginas ese día
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impresora_historicos');
    }
};
