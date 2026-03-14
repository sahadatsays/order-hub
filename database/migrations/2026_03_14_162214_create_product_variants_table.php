<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('name')->comment('e.g. Red / XL');
            $table->string('sku')->nullable();
            $table->decimal('price', 10, 2)->nullable()->comment('override product price');
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->integer('quantity_on_hand')->default(0);
            $table->json('option_values')->nullable()->comment('{"color":"Red","size":"XL"}');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('tenant_id');
            $table->index('product_id');
            $table->index(['tenant_id', 'sku']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
