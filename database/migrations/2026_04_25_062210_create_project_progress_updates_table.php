<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_progress_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');
            $table->decimal('progress_percentage', 5, 2);
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_progress_updates');
    }
};
