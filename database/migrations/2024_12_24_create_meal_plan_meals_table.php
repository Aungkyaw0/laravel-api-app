<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meal_plan_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('meal_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Optional: Add a unique constraint to prevent duplicate entries
            $table->unique(['meal_plan_id', 'meal_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('meal_plan_meals');
    }
}; 