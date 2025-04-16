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

        // Schema::create('applications', function (Blueprint $table) {
        //     $table->id('Application_ID');
        //     $table->unsignedBigInteger('user_id');
        //     $table->unsignedBigInteger('Policy_ID');
        //     $table->enum('Status', ['Approved', 'Pending', 'Rejected'])->default('Pending');
        //     $table->date('Date_Applied');
        //     $table->timestamps();
        
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('Policy_ID')->references('Policy_ID')->on('policies')->onDelete('cascade');
        // });
        

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
