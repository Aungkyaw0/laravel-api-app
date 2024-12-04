<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->nullable()->constrained();
            $table->string('pickup_address');
            $table->string('delivery_address');
            $table->dateTime('pickup_time');
            $table->dateTime('delivery_time');
            $table->enum('meal_type', ['hot', 'frozen']);
            $table->enum('status', ['pending', 'assigned', 'picked_up', 'delivered', 'cancelled']);
            $table->decimal('distance', 8, 2);
            $table->json('route_details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}; 