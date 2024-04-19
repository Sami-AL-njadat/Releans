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
        Schema::create('stock_trackings', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('inventory_id')->nullable();
            // $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('quantities')->nullable();
            $table->enum('type', ['addition', 'deduction'])->nullable();
            $table->string('reason')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_trackings');
    }
};