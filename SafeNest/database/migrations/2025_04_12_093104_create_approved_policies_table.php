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
};
