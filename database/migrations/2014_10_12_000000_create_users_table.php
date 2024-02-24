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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('title')->nullable();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('school_id')->nullable()->constrained('schools')->nullOnDelete();
            $table->string('current_role')->nullable()->constrained('roles')->nullOnDelete();
            $table->string('password');
            $table->string('status')->nullable()->default('active');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
