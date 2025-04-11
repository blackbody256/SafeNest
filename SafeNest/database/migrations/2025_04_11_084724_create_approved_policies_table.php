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
            $table->id('approved_policy_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('policy_id')->constrained('policy')->onDelete('cascade');
            // the foreignid is used to link the approved policy to the policy table.
            // the onDelete cascade is used to delete all records in the approved policy table if the policy is deleted.
            $table->
            
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
};
