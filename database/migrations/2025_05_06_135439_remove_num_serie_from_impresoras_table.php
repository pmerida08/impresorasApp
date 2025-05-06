<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->dropColumn('num_serie');
        });
    }

    public function down()
    {
        Schema::table('impresoras', function (Blueprint $table) {
            $table->string('num_serie')->nullable(); // o el tipo original que tenía
        });
    }

};
