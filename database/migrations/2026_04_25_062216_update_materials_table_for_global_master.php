<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            // Kita menghapus constraint jika ada.
            // Sebelumnya ada $table->foreignId('project_id')
            if (Schema::hasColumn('materials', 'project_id')) {
                // Drop foreign key by naming convention (materials_project_id_foreign)
                $table->dropForeign(['project_id']);
                $table->dropColumn('project_id');
            }

            if (!Schema::hasColumn('materials', 'kode_material')) {
                $table->string('kode_material')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('materials', 'satuan')) {
                $table->string('satuan')->default('pcs')->after('nama_material');
            }
            if (!Schema::hasColumn('materials', 'min_stock')) {
                $table->integer('min_stock')->default(0)->after('jumlah_tersedia');
            }
            if (!Schema::hasColumn('materials', 'max_stock')) {
                $table->integer('max_stock')->default(0)->after('min_stock');
            }
            if (!Schema::hasColumn('materials', 'reorder_point')) {
                $table->integer('reorder_point')->default(0)->after('max_stock');
            }

            // Hapus kolom yang pindah ke project_materials (jumlah_kebutuhan, kekurangan) jika ingin master global
            // Namun karena kita harus backward compatible, biarkan saja sementara atau kita drop.
            if (Schema::hasColumn('materials', 'jumlah_kebutuhan')) {
                $table->dropColumn('jumlah_kebutuhan');
            }
            if (Schema::hasColumn('materials', 'kekurangan')) {
                $table->dropColumn('kekurangan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->integer('jumlah_kebutuhan')->default(0);
            $table->integer('kekurangan')->default(0);

            $table->dropColumn(['kode_material', 'satuan', 'min_stock', 'max_stock', 'reorder_point']);
        });
    }
};
