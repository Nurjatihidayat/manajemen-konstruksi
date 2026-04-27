<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_materials', function (Blueprint $table) {
            $table->integer('jumlah_tersedia')->default(0)->after('jumlah_dialokasikan');
            $table->integer('total_diterima')->default(0)->after('jumlah_tersedia');
        });
    }

    public function down(): void
    {
        Schema::table('project_materials', function (Blueprint $table) {
            $table->dropColumn(['jumlah_tersedia', 'total_diterima']);
        });
    }
};
