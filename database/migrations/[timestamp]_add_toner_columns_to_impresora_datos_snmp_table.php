<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('impresora_datos_snmp', function (Blueprint $table) {
            $table->integer('black_toner')->nullable()->after('modelo');
            $table->integer('cyan_toner')->nullable()->after('black_toner');
            $table->integer('magenta_toner')->nullable()->after('cyan_toner');
            $table->integer('yellow_toner')->nullable()->after('magenta_toner');
        });
    }

    public function down()
    {
        Schema::table('impresora_datos_snmp', function (Blueprint $table) {
            $table->dropColumn(['black_toner', 'cyan_toner', 'magenta_toner', 'yellow_toner']);
        });
    }
};