<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clock_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('clock_in')->nullable();       // Entrada
            $table->time('lunch_start')->nullable();   // Saída Almoço
            $table->time('lunch_end')->nullable();     // Volta Almoço
            $table->time('clock_out')->nullable();      // Saída Final
            $table->integer('total_minutes')->default(0); // Carga horária líquida calculada
            $table->timestamps();

            // Garante que o usuário só tenha um registro de ponto por dia
            $table->unique(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clock_entries');
    }
};