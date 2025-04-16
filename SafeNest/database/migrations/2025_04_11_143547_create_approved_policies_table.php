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
        Schema::create('approved_policies', function (Blueprint $table) {
            $table->id('Approved_policy_ID');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('Policy_ID');
            $table->date('Expiry_Date');
            $table->enum('Status', ['Active', 'Expired'])->default('Active');
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Policy_ID')->references('Policy_ID')->on('policies')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approved_policies');
    }
};
