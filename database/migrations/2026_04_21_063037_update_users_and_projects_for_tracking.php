<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Temporarily allow both role names to prevent truncation error
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'manajer', 'gudang') NOT NULL DEFAULT 'gudang'");

        // 2. Update existing data
        DB::table('users')->where('role', 'manager')->update(['role' => 'manajer']);

        // 3. Set to the final desired enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manajer', 'gudang') NOT NULL DEFAULT 'gudang'");

        Schema::table('projects', function (Blueprint $table) {
            // Check if column exists before renaming to avoid error if partly migrated
            if (Schema::hasColumn('projects', 'user_id')) {
                $table->renameColumn('user_id', 'manager_id');
            }
            $table->enum('status_proyek', ['berjalan', 'selesai'])->default('berjalan');
            $table->integer('progres')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['status_proyek', 'progres']);
            if (Schema::hasColumn('projects', 'manager_id')) {
                $table->renameColumn('manager_id', 'user_id');
            }
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'gudang') NOT NULL DEFAULT 'gudang'");
        DB::table('users')->where('role', 'manajer')->update(['role' => 'manager']);
    }
};
