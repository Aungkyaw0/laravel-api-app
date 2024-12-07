<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('company_name');
            $table->string('company_email');
            $table->string('phone');
            $table->string('location');
            $table->string('business_type');
            $table->string('service_offer');
            $table->decimal('latitude', 10, 8)->nullable();  // Add this for latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Add this for longitude
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
}; 