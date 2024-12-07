<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->string('emergency_contact');
            $table->string('emergency_phone');
            $table->boolean('has_vehicle')->default(false);
            $table->string('vehicle_type')->nullable();
            $table->string('license_number')->nullable();
            $table->string('status')->default('unavailable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'volunteers');
    }
}; 