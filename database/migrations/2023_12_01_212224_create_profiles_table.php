<?php

use App\Models\Institution;
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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('profileable_id');
            $table->string('profileable_type');
            $table->string('gender')->nullable();
            $table->string('blood')->nullable();
            $table->string('address')->nullable();
            $table->string('occupation')->nullable();
            $table->date('admitted_on')->nullable(); //it can be date employed or dated admitted for students
            $table->string('disability')->nullable();
            $table->string('religion')->nullable();
            $table->json('hobbies')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->string('reg_class')->nullable();
            $table->foreignIdFor(Institution::class)->nullable()->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
