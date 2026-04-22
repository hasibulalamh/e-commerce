<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add courier and delivery fields to orders table
        Schema::table('orders', function (Blueprint $blueprint) {
            if (!Schema::hasColumn('orders', 'delivery_zone')) {
                $blueprint->string('delivery_zone')->nullable()->after('city');
            }
            if (!Schema::hasColumn('orders', 'tracking_id')) {
                $blueprint->string('tracking_id')->nullable()->after('transaction_id');
            }
            if (!Schema::hasColumn('orders', 'courier_status')) {
                $blueprint->string('courier_status')->nullable()->after('tracking_id');
            }
            if (!Schema::hasColumn('orders', 'rider_name')) {
                $blueprint->string('rider_name')->nullable()->after('courier_status');
            }
            if (!Schema::hasColumn('orders', 'rider_phone')) {
                $blueprint->string('rider_phone')->nullable()->after('rider_name');
            }
        });

        // Add free delivery flag to coupons table
        Schema::table('coupons', function (Blueprint $blueprint) {
            if (!Schema::hasColumn('coupons', 'is_free_delivery')) {
                $blueprint->boolean('is_free_delivery')->default(false)->after('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['delivery_zone', 'tracking_id', 'courier_status', 'rider_name', 'rider_phone']);
        });

        Schema::table('coupons', function (Blueprint $blueprint) {
            $blueprint->dropColumn('is_free_delivery');
        });
    }
};
