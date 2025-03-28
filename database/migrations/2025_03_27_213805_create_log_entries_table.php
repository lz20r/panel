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
        Schema::create('log_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');  // Relacionado con el usuario
            $table->string('type');  // Tipo de log (por ejemplo: 'login', 'error', 'info', etc.)
            $table->text('message');  // Mensaje del log
            $table->json('metadata')->nullable();  // Metadatos adicionales, como la IP, URL, etc.
            $table->string('ip_address')->nullable();  // Columna para almacenar la IP
            $table->timestamps();  // Timestamps: created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_entries');
    }
};
