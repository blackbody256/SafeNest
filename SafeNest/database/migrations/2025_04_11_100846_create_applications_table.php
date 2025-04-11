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
        Schema::create('applications', function (Blueprint $table) {
            $table->id('Application_ID');
            $table->unsignedBigInteger('User_ID');
            $table->unsignedBigInteger('Policy_ID');
            $table->enum('Status', ['Approved', 'Pending', 'Rejected'])->default('Pending');
            $table->date('Date_Applied');
            $table->timestamps();
        
            $table->foreign('User_ID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Policy_ID')->references('Policy_ID')->on('policies')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
