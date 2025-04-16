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
        // Schema::table('approved_policies', function (Blueprint $table) {
        //     // Fix the column type and rename in one go
        //     $table->unsignedBigInteger('user_id')->change();
        //     $table->renameColumn('User_ID', 'user_id');
        // });
        DB::statement("ALTER TABLE approved_policies CHANGE `User_ID` `user_id` BIGINT UNSIGNED NOT NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approved_policies', function (Blueprint $table) {
            //
        });
    }
};
