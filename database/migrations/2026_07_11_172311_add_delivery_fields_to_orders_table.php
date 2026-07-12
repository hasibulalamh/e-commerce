<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('delivery_channel', ['in_house', 'steadfast'])->default('steadfast')->after('status');
            $table->foreignId('delivery_staff_id')->nullable()->constrained('delivery_staff')->nullOnDelete()->after('delivery_channel');
            $table->timestamp('delivered_at')->nullable()->after('delivery_staff_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['delivery_staff_id']);
            $table->dropColumn(['delivery_channel', 'delivery_staff_id', 'delivered_at']);
        });
    }
};
