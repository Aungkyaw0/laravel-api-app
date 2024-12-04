<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('phone');
            $table->string('address');
            $table->string('emergency_contact');
            $table->string('emergency_phone');
            $table->boolean('has_vehicle')->default(false);
            $table->string('vehicle_type')->nullable();
            $table->string('license_number')->nullable();
            $table->boolean('background_check_passed')->default(false);
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteers');
    }
}; 