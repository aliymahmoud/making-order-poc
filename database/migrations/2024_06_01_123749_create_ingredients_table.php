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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('maximum_stock', unsigned: true);
            $table->integer('stock', unsigned: true);
            $table->integer('minimum_stock', unsigned: true)->default(50);
            $table->enum('minimum_stock_unit', ['fixed', 'percentage'])->default('percentage');
            $table->boolean('notified')->default(false);
            $table->enum('unit', ['g', 'ml', 'unit']);
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
