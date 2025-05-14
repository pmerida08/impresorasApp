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
            $table->string('black_max_capacity')->nullable()->after('black_toner');
            // $table->integer('cyan_max_capacity')->nullable()->after('cyan_toner');
            // $table->integer('magenta_max_capacity')->nullable()->after('magenta_toner');
            // $table->integer('yellow_max_capacity')->nullable()->after('yellow_toner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('impresora_datos_snmp', function (Blueprint $table) {
            $table->dropColumn('black_max_capacity');
            // $table->dropColumn('cyan_max_capacity');
            // $table->dropColumn('magenta_max_capacity');
            // $table->dropColumn('yellow_max_capacity');
        });
    }
};
