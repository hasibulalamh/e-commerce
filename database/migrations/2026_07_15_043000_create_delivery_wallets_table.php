<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Wallet transactions for delivery staff
        Schema::create('delivery_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_staff_id')->constrained('delivery_staff')->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['earning', 'payout', 'bonus', 'deduction'])->default('earning');
            $table->decimal('amount', 10, 2);
            $table->decimal('balance_after', 10, 2)->default(0);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Add wallet balance and delivery fee fields
        Schema::table('delivery_staff', function (Blueprint $table) {
            $table->decimal('wallet_balance', 10, 2)->default(0)->after('password');
            $table->decimal('total_earned', 10, 2)->default(0)->after('wallet_balance');
        });

        // Add delivery fee per order
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'delivery_fee')) {
                $table->decimal('delivery_fee', 8, 2)->default(0)->after('delivered_at');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_wallet_transactions');

        Schema::table('delivery_staff', function (Blueprint $table) {
            $table->dropColumn(['wallet_balance', 'total_earned']);
        });

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'delivery_fee')) {
                $table->dropColumn('delivery_fee');
            }
        });
    }
};
