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
            $table->string('name')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('postal_code')->nullable()->change();
            $table->decimal('shipping_cost')->nullable()->change();
            $table->decimal('tax')->nullable()->change();
            $table->string('payment_status')->nullable()->change();
            $table->string('transaction_id')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('payment_method')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('postal_code')->nullable(false)->change();
            $table->decimal('shipping_cost')->nullable(false)->change();
            $table->decimal('tax')->nullable(false)->change();
            $table->string('payment_status')->nullable(false)->change();
            $table->string('transaction_id')->nullable(false)->change();
            $table->string('status')->nullable(false)->change();
            $table->string('payment_method')->nullable(false)->change();
        });
    }
};
