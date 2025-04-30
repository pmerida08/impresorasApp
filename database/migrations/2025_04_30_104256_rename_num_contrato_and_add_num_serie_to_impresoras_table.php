<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->renameColumn('num_contrato', 'contrato');
            $table->string('num_serie')->nullable()->after('contrato');
        });
    }

    public function down()
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->renameColumn('contrato', 'num_contrato');
            $table->dropColumn('num_serie');
        });
    }
};
