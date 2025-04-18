<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id('Claim_ID');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('Policy_ID');
            $table->string('Description', 50);  // Changed from 'reason' to 'description' with size 50
            $table->enum('Status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            
            $table->timestamp('Date_submitted')->default(DB::raw('CURRENT_TIMESTAMP'));  // Add Date_submitted here
            $table->string('attachment')->nullable();
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('policy_id')->references('Policy_ID')->on('policies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};