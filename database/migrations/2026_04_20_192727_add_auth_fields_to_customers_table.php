<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Social login
            $table->string('google_id')->nullable()->after('image');
            $table->string('facebook_id')->nullable()->after('google_id');
            $table->string('provider')->nullable()->after('facebook_id');

            // Email verification OTP
            $table->timestamp('email_verified_at')->nullable()->after('provider');
            $table->string('otp_code', 6)->nullable()->after('email_verified_at');
            $table->timestamp('otp_expires_at')->nullable()->after('otp_code');

            // Two-Factor Authentication
            $table->boolean('two_factor_enabled')->default(false)->after('otp_expires_at');
            $table->string('two_factor_code', 6)->nullable()->after('two_factor_enabled');
            $table->timestamp('two_factor_expires_at')->nullable()->after('two_factor_code');

            // Make password nullable for social login users
            $table->string('password')->nullable()->change();
        });

        // Password resets table for customers
        Schema::create('customer_password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'google_id', 'facebook_id', 'provider',
                'email_verified_at', 'otp_code', 'otp_expires_at',
                'two_factor_enabled', 'two_factor_code', 'two_factor_expires_at'
            ]);
        });

        Schema::dropIfExists('customer_password_resets');
    }
};
