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
        Schema::create('assignment_activities', function (Blueprint $table) {
            $table->id();
                    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('assignment_title')->nullable();
        $table->integer('marks_awarded')->nullable();
        $table->text('description')->nullable();
        $table->string('status')->default('pending'); // or enum cast if using enum
        $table->date('activity_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_activities');
    }
};
