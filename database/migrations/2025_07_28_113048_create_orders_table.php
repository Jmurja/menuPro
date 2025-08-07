<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // <-- novo
            $table->boolean('is_closed')->default(false); // <-- novo
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->string('table'); // ex: A01, B10
            $table->string('status')->default('aberto'); // aberto | fechado
            $table->string('payment_method')->nullable(); // dinheiro | cartao_credito | cartao_debito | pix
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
