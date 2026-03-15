<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->cascadeOnDelete();
            $table->string('name');
            $table->string('event');
            $table->string('channel')->comment('database, email, sms');
            $table->string('subject')->nullable()->comment('email subject or SMS title');
            $table->text('body');
            $table->json('variables')->nullable()->comment('list of supported variables');
            $table->boolean('is_system')->default(false)->comment('system default template');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('tenant_id');
            $table->index(['event', 'channel']);
            $table->unique(['tenant_id', 'event', 'channel']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
