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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_service_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->json('ingredients');
            $table->json('nutritional_info');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner']);
            $table->json('dietary_flags'); // vegetarian, vegan, gluten-free, etc.
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
