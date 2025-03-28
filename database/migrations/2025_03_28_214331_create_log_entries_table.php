<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogEntriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_entries', function (Blueprint $table) {
            $table->id();
            $table->text('message'); // 📝 Mensaje del log
            $table->string('type'); // 🔍 Tipo de log (info, error, login, etc.)

            // 👤 Usuario (opcional)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // 🌐 Datos de la petición
            $table->string('url')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('method')->nullable();
            $table->string('route')->nullable();
            $table->json('input')->nullable();

            // ⚠️ Excepción
            $table->string('exception')->nullable();

            // 🌍 IP
            $table->string('ip')->nullable();

            // 🕒 Fecha de creación
            $table->timestamp('created_at')->useCurrent();

            // 📦 Contexto adicional
            $table->json('context')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_entries');
    }
}
