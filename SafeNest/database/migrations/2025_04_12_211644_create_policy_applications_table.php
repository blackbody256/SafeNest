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
        Schema::create('policy_applications', function (Blueprint $table) {
            $table->id('Application_ID');
            $table->foreignId('User_ID')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('Policy_ID')->constrained('policies', 'Policy_ID')->onDelete('cascade');
            $table->string('Status')->default('pending');
            $table->string('Requirements_path')->nullable();
            $table->text('notes')->nullable(); // Optional field for notes/comments
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_applications');
    }
};
