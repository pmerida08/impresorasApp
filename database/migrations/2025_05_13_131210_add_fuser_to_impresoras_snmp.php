<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('impresora_datos_snmp', function (Blueprint $table) {
        $table->string('fuser_status')->nullable()->default(null);
    });
}

public function down(): void
{
    Schema::table('impresora_datos_snmp', function (Blueprint $table) {
        $table->dropColumn('fuser_status');
    });
}
};
