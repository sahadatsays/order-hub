<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->enum('type', [
                'facebook', 'woocommerce', 'shopify',
                'whatsapp', 'website', 'pos',
            ]);
            $table->string('name');
            $table->json('credentials')->nullable();
            $table->json('settings')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('last_synced_at')->nullable();
            $table->string('sync_status')->nullable()->comment('idle, syncing, error');
            $table->text('sync_error')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'type']);
            $table->index('tenant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
