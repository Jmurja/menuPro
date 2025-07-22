<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->integer('stock_quantity')->nullable()->after('is_active');
            $table->time('availability_start_time')->nullable()->after('stock_quantity');
            $table->time('availability_end_time')->nullable()->after('availability_start_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('stock_quantity');
            $table->dropColumn('availability_start_time');
            $table->dropColumn('availability_end_time');
        });
    }
};
