<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('impresora_datos_snmp', function (Blueprint $table) {
            $table->string('modelo')->nullable()->after('num_serie');
        });
    }

    public function down()
    {
        Schema::table('impresora_datos_snmp', function (Blueprint $table) {
            $table->dropColumn('modelo');
        });
    }
};
