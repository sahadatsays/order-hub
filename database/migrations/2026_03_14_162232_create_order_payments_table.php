<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('collected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('method', 50); // cash, card, bank_transfer, mobile_banking, cod
            $table->decimal('amount', 12, 2);
            $table->decimal('tendered', 12, 2)->nullable(); // amount tendered (for cash)
            $table->decimal('change_amount', 12, 2)->default(0); // change returned
            $table->string('reference')->nullable(); // transaction ref, receipt #
            $table->string('note')->nullable();
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_type', 30)->default('manual')->after('source');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payments');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_type');
        });
    }
};
