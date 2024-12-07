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
        Schema::create('meal_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('caregiver_id')->constrained()->cascadeOnDelete();
            $table->foreignId('menu_id')->constrained()->cascadeOnDelete()->after('caregiver_id');
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete()->after('menu_id');
            $table->string('deliver_meal_type');
            $table->date('meal_date');
            $table->string('dietary_category')->nullable();
            $table->boolean('is_general')->default(false);
            $table->enum('status', ['scheduled', 'completed'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_plans');
    }
}; 