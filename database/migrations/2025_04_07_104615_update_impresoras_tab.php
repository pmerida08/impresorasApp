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
            // Eliminar columnas relacionadas con las copias
            $table->dropColumn(['copias_dia', 'copias_mes', 'copias_anio']);

            // Añadir las columnas necesarias
            $table->string('tipo')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('usuario')->nullable();
            $table->string('ip')->nullable();
            $table->string('mac')->nullable();
            $table->string('nombre_reserva_dhcp')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('nombre_cola_hacos')->nullable();
            $table->string('num_serie')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('impresoras', function (Blueprint $table) {
            // Restaurar las columnas eliminadas
            $table->integer('copias_dia')->nullable();
            $table->integer('copias_mes')->nullable();
            $table->integer('copias_anio')->nullable();

            // Eliminar las columnas añadidas
            $table->dropColumn([
                'tipo',
                'ubicacion',
                'usuario',
                'ip',
                'mac',
                'nombre_reserva_dhcp',
                'observaciones',
                'nombre_cola_hacos',
                'num_serie',
            ]);
        });
    }
};
