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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default shipping rates
        DB::table('settings')->insert([
            ['key' => 'shipping_charge_dhaka', 'value' => '70'],
            ['key' => 'shipping_charge_outside', 'value' => '130'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
