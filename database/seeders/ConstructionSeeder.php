<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ConstructionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::where('role', 'manajer')->first();
        $gudang = User::where('role', 'gudang')->first();

        $p1 = Project::create([
            'nama_proyek' => 'Pembangunan Jembatan Merdeka',
            'lokasi' => 'Bandung, Jawa Barat',
            'tanggal_mulai' => '2026-05-01',
            'tanggal_selesai' => '2026-12-31',
            'manager_id' => $manager ? $manager->id : null,
            'progres' => 25,
            'status_proyek' => 'berjalan',
        ]);

        $p1->materials()->createMany([
            ['nama_material' => 'Semen (Sak)', 'jumlah_tersedia' => 200, 'jumlah_kebutuhan' => 500],
            ['nama_material' => 'Pasir (M3)', 'jumlah_tersedia' => 100, 'jumlah_kebutuhan' => 100],
            ['nama_material' => 'Besi Beton', 'jumlah_tersedia' => 50, 'jumlah_kebutuhan' => 150],
        ]);

        $p2 = Project::create([
            'nama_proyek' => 'Renovasi Gedung Juang',
            'lokasi' => 'Jakarta Pusat',
            'tanggal_mulai' => '2026-06-15',
            'tanggal_selesai' => '2026-11-20',
            'manager_id' => $manager ? $manager->id : null,
            'progres' => 60,
            'status_proyek' => 'berjalan',
        ]);

        $p2->materials()->createMany([
            ['nama_material' => 'Batu Bata', 'jumlah_tersedia' => 1000, 'jumlah_kebutuhan' => 800],
            ['nama_material' => 'Cat Tembok (Pail)', 'jumlah_tersedia' => 5, 'jumlah_kebutuhan' => 50],
            ['nama_material' => 'Keramik 40x40', 'jumlah_tersedia' => 0, 'jumlah_kebutuhan' => 200],
        ]);

        // Assign gudang user to the first project
        if ($gudang && $p1) {
            $gudang->update(['assigned_project_id' => $p1->id]);
        }
    }
}
