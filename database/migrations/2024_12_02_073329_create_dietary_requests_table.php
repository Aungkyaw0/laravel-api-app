<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dietary_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->string('current_dietary_requirement');
            $table->string('current_prefer_meal');
            $table->string('requested_dietary_requirement');
            $table->string('requested_prefer_meal');
            $table->text('reason');
            $table->text('additional_notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('caregiver_id')->nullable()->constrained()->after('member_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('dietary_requests', function (Blueprint $table) {
            $table->dropForeign(['caregiver_id']);
            $table->dropColumn('caregiver_id');
        });    
    }
};