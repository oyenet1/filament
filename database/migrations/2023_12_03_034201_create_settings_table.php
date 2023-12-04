<?php

use App\Models\School;
use Nnjeim\World\Models\City;
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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('staff_prefix')->nullable();
            $table->string('student_prefix')->nullable();
            $table->string('parent_prefix')->nullable();
            $table->integer('sms_unit')->nullable();
            $table->string('color')->nullable();
            $table->string('paystack_pk')->nullable();
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
        Schema::dropIfExists('settings');
    }
};
