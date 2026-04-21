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
        Schema::create('customer_coupons', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $blueprint->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
            $blueprint->timestamp('collected_at')->useCurrent();
            $blueprint->boolean('is_used')->default(false);
            $blueprint->timestamps();
            
            $blueprint->unique(['customer_id', 'coupon_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_coupons');
    }
};
