<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->json('source_raw_payload')->nullable()->after('source_order_id')
                ->comment('raw API payload from source platform');
        });

        Schema::table('shipments', function (Blueprint $table) {
            $table->json('request_payload')->nullable()->after('notes')
                ->comment('raw courier API request payload');
            $table->json('response_payload')->nullable()->after('request_payload')
                ->comment('raw courier API response payload');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('source_raw_payload');
        });

        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['request_payload', 'response_payload']);
        });
    }
};
