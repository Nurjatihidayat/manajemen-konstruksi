<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_material_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_progress_update_id')->constrained('project_progress_updates')->name('fk_prog_update_usage')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->integer('quantity_used');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_material_usages');
    }
};
