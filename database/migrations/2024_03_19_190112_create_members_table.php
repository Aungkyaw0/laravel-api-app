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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('phone');
            $table->string('address');
            $table->enum('dietary_requirement', ['none', 'vegetarian', 'vegan', 'halal', 'gluten-free']);
            $table->enum('prefer_meal', ['hot', 'frozen', 'both']);
            $table->decimal('latitude', 10, 8)->nullable();  // Add this for latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Add this for longitude
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};