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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained();
            $table->string("alias_name");
            $table->string("slug")->unique();
            $table->string("avatar")->nullable();
            $table->string("gender")->nullable();
            $table->string("designation")->nullable();
            $table->string("employment_type")->nullable();
            $table->boolean("status")->default(true);
            $table->string('google2fa_secret')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
            $table->dropColumn("alias_name");
            $table->dropColumn("slug");
            $table->dropColumn("avatar");
            $table->dropColumn("gender");
            $table->dropColumn("designation");
            $table->dropColumn("employment_type");
            $table->dropColumn("status");
            $table->dropColumn('google2fa_secret');
        });
    }
};
