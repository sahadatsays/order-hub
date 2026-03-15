<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Change the type column from enum to string to support dynamic integration types
        Schema::table('integrations', function (Blueprint $table) {
            $table->string('type', 50)->change();
        });
    }

    public function down(): void
    {
        // Revert to original enum if needed
        Schema::table('integrations', function (Blueprint $table) {
            $table->enum('type', [
                'facebook', 'woocommerce', 'shopify',
                'whatsapp', 'website', 'pos',
            ])->change();
        });
    }
};
