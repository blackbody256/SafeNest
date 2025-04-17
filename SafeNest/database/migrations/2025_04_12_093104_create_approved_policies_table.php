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

            $table->id("Approved_Policy_ID");
            $table->foreignId("User_ID")->constrained("users", "id")->onDelete("cascade");
            $table->foreignId("Policy_ID")->constrained("policies", "Policy_ID")->onDelete("cascade");
            $table->timestamp("expires_at")->nullable(); 
            $table->string("Status")->default("active");
            $table->timestamps(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approved_policies');
    }

    // Treasure check this method below

    //  /**
    //  * Run the migrations.
    //  */
    // public function up(): void
    // {
    //     Schema::create('approved_policies', function (Blueprint $table) {
    //         $table->id('Approved_policy_ID');
    //         $table->unsignedBigInteger('user_id');
    //         $table->unsignedBigInteger('Policy_ID');
    //         $table->date('Expiry_Date');
    //         $table->enum('Status', ['Active', 'Expired'])->default('Active');
    //         $table->timestamps();
        
    //         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    //         $table->foreign('Policy_ID')->references('Policy_ID')->on('policies')->onDelete('cascade');
    //     });
        
    // }

    // /**
    //  * Reverse the migrations.
    //  */c
    // public function down(): void
    // {
    //     Schema::dropIfExists('approved_policies');
    // }
};
