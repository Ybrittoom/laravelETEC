<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bikes', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Nome do produto
            $table->string('brand');                         // Marca
            $table->string('model')->nullable();             // Modelo
            $table->enum('category', [                       // Categoria
                'mountain', 'speed', 'urbana', 'infantil',
                'eletrica', 'bmx', 'acessorio', 'peca', 'outro'
            ])->default('outro');
            $table->text('description')->nullable();         // Descrição
            $table->decimal('cost_price', 10, 2)->default(0);   // Preço de custo
            $table->decimal('sale_price', 10, 2)->default(0);   // Preço de venda
            $table->integer('stock')->default(0);            // Estoque atual
            $table->integer('stock_min')->default(0);        // Estoque mínimo (alerta)
            $table->string('sku')->nullable()->unique();     // Código do produto
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('image')->nullable();             // Foto (caminho)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bikes');
    }
};