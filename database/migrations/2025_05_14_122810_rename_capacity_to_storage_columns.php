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
        Schema::table('impresora_datos_snmp', function (Blueprint $table) {
            $table->renameColumn('max_capacity', 'max_storage');
            $table->renameColumn('black_max_capacity', 'black_max_storage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('impresora_datos_snmp', function (Blueprint $table) {
            $table->renameColumn('max_storage', 'max_capacity');
            $table->renameColumn('black_max_storage', 'black_max_capacity');
        });
    }
};