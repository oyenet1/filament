<?php

use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('avatar_url')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('domain')->nullable()->unique();
            $table->string('status')->nullable()->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('school_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(School::class)->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
        Schema::dropIfExists('school_user');
    }
};
