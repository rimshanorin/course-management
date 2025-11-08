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
        Schema::create('session_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->integer('session_week')->nullable();
$table->integer('attendance_count')->nullable();
$table->integer('participation_points')->nullable();
$table->text('notes')->nullable();
$table->date('activity_date')->nullable();
 $table->string('status')->default('pending'); // Ihave added this line when adding alerts
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_activities');
    }
};
