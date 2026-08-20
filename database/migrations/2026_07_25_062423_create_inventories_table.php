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
        Schema::create('inventories', function (Blueprint $table) {
            $table->uuid('inventory_id')->primary();
            $table->uuid('product_id');
            $table->uuid('warehouse_id');
            $table->integer('quantityonhand');
            $table->text('lastcounteddate');

            $table->foreign('product_id')->references('product_id')->on('products');
            $table->foreign('warehouse_id')->references('warehouse_id')->on('warehouses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
