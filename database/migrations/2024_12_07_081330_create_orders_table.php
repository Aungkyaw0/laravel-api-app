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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('caregiver_id')->constrained();
            $table->foreignId('volunteer_id')->nullable()->constrained();
            $table->foreignId('partner_id')->constrained();
            $table->foreignId('meal_plan_id')->constrained();
            $table->string('delivery_meal_type');
            $table->string('partner_status')->default('pending');
            $table->string('delivery_status');
            $table->date('delivery_start_date')->nullable();
            $table->date('delivery_end_date')->nullable();
            $table->string('delivery_confirmation_code')->nullable();
            $table->string('delivery_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
