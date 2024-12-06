<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('member_kitchen_distances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('food_service_id')->constrained()->cascadeOnDelete();
            $table->decimal('distance', 8, 2);
            $table->boolean('is_within_range')->default(false);
            $table->timestamps();

            // Unique constraint to prevent duplicate entries
            $table->unique(['member_id', 'food_service_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('member_kitchen_distances');
    }
}; 