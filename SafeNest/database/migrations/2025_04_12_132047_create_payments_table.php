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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Added missing user_id column
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Add foreign key constraint
            $table->unsignedBigInteger('policy_id')->nullable();
            $table->unsignedBigInteger('approved_policy_id')->nullable();
            $table->foreign('approved_policy_id')
                ->references('Approved_Policy_ID')
                ->on('approved_policies')
                ->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->dateTime('due_date')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->enum('status', ['pending', 'paid', 'failed', 'overdue'])->default('pending');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};