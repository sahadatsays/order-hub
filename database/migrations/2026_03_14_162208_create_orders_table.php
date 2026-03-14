<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            // Order identity
            $table->string('order_number')->unique();

            // Source channel
            $table->enum('source', [
                'facebook', 'website', 'whatsapp', 'woocommerce',
                'shopify', 'pos', 'manual', 'phone', 'other',
            ])->default('manual');
            $table->string('source_order_id')->nullable()->comment('external order ID from source');

            // Customer info (snapshot at time of order)
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();

            // Shipping address
            $table->text('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_country', 2)->nullable();
            $table->string('shipping_postal_code')->nullable();

            // Order status lifecycle
            $table->enum('status', [
                'pending', 'confirmed', 'processing',
                'packed', 'shipped', 'delivered',
                'cancelled', 'refunded', 'on_hold',
            ])->default('pending');

            // Payment
            $table->enum('payment_status', ['unpaid', 'partial', 'paid', 'refunded'])->default('unpaid');
            $table->string('payment_method')->nullable();

            // Financials
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->string('discount_code')->nullable();
            $table->decimal('shipping_charge', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->string('currency', 3)->default('BDT');

            $table->text('notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamp('ordered_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();

            $table->index('tenant_id');
            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'source']);
            $table->index('customer_id');
            $table->index('ordered_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
