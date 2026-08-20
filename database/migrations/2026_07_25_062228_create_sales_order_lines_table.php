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
        Schema::create('sales_order_lines', function (Blueprint $table) {
            $table->uuid('orderline_id')->primary();
            $table->uuid('order_id');
            $table->uuid('product_id');
            $table->text('quantity');
            $table->text('unitprice');
            
            $table->foreign('order_id')->references('order_id')->on('sales_orders');
            $table->foreign('product_id')->references('product_id')->on('products');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_lines');
    }
};
