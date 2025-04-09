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
        Schema::table('impresoras', function (Blueprint $table) {
            $table->dropColumn('fotocopias');
            $table->integer('copias_dia')->default(0);
            $table->integer('copias_semana')->default(0);
            $table->integer('copias_anio')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->integer('fotocopias')->default(0);
            $table->dropColumn(['copias_dia', 'copias_semana', 'copias_anio']);
        });
    }
};
