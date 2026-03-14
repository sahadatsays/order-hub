<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('rule_id')->nullable()->constrained('notification_rules')->nullOnDelete();
            $table->string('event');
            $table->string('channel');
            $table->string('recipient_type')->comment('user, customer, email, phone');
            $table->unsignedBigInteger('recipient_id')->nullable();
            $table->string('recipient_contact')->nullable()->comment('email or phone number');
            $table->string('subject')->nullable();
            $table->text('body');
            $table->string('status')->default('pending')->comment('pending, sent, failed, read');
            $table->string('related_type')->nullable()->comment('Order, Shipment, etc.');
            $table->unsignedBigInteger('related_id')->nullable();
            $table->string('idempotency_key')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();

            $table->index('tenant_id');
            $table->index(['recipient_type', 'recipient_id']);
            $table->index(['channel', 'status']);
            $table->index(['related_type', 'related_id']);
            $table->unique('idempotency_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
