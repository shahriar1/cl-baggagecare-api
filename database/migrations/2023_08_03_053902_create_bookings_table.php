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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('drop_off_date');
            $table->time('drop_off_time');
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->integer('luggage_quantity');
            $table->string('phone_number')->nullable();
            $table->date('pick_up_date')->nullable();
            $table->time('pick_up_time');
            $table->decimal('total_price', 8, 2);
            $table->text('notes')->nullable();
            $table->boolean('released')->nullable()->default(false);
            $table->text('qr_code')->nullable();
            $table->text('payment_qr_code')->nullable();
            $table->string('booking_status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
