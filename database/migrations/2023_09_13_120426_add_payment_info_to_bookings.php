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
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->decimal('insurance_amount', 10, 2)->nullable();
            $table->decimal('tips_amount', 10, 2)->nullable();
            $table->boolean('insuranceEnabled')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('payment_amount');
            $table->dropColumn('insurance_amount');
            $table->dropColumn('tips_amount');
            $table->dropColumn('insuranceEnabled');
        });
    }
};
