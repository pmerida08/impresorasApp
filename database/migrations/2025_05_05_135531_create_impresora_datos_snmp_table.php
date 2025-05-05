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
        Schema::create('impresora_datos_snmp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('impresora_id')->constrained()->onDelete('cascade');
            $table->string('mac')->nullable();
            $table->unsignedInteger('paginas_total')->default(0);
            $table->unsignedInteger('paginas_bw')->default(0);
            $table->unsignedInteger('paginas_color')->default(0);
            $table->string('num_serie')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impresora_datos_snmp');
    }
};
