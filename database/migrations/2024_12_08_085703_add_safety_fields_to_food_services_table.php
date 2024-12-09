<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('food_services', function (Blueprint $table) {
        $table->boolean('food_safety_certified')->default(false);
        $table->date('last_inspection_date')->nullable();
        $table->integer('safety_rating')->default(0);
        $table->json('safety_procedures')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('food_services', function (Blueprint $table) {
            //
        });
    }
};
