<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('log_entries', function (Blueprint $table) {
            $table->string('ip_address')->nullable();  // Agregar la columna ip_address
        });
    }

    public function down()
    {
        Schema::table('log_entries', function (Blueprint $table) {
            $table->dropColumn('ip_address');  // Eliminar la columna ip_address si se revierte la migración
        });
    }
};