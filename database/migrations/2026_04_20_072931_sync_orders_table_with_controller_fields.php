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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->after('id');
            $table->string('receiver_name')->nullable()->after('customer_id');
            $table->string('receiver_email')->nullable()->after('receiver_name');
            $table->string('receiver_mobile')->nullable()->after('receiver_email');
            $table->text('receiver_address')->nullable()->after('receiver_mobile');
            $table->string('receiver_city')->nullable()->after('receiver_address');
            $table->string('payment_method')->nullable()->after('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_id',
                'receiver_name',
                'receiver_email',
                'receiver_mobile',
                'receiver_address',
                'receiver_city',
                'payment_method'
            ]);
        });
    }
};
