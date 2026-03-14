<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2)->default(0)->comment('selling price');
            $table->decimal('cost_price', 10, 2)->default(0);
            $table->decimal('compare_price', 10, 2)->nullable()->comment('original/compare at price');
            $table->decimal('weight', 8, 3)->nullable()->comment('in kg');
            $table->json('attributes')->nullable()->comment('color, size, etc.');
            $table->boolean('is_active')->default(true);
            $table->boolean('track_inventory')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('tenant_id');
            $table->index(['tenant_id', 'sku']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
