<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Project;

echo "--- DATABASE VERIFICATION ---\n";

$admin = User::where('role', 'admin')->first();
$manager = User::where('role', 'manajer')->first();
$gudang = User::where('role', 'gudang')->first();

echo "Admin: " . ($admin ? "FOUND ($admin->email)" : "NOT FOUND") . "\n";
echo "Manager: " . ($manager ? "FOUND ($manager->email)" : "NOT FOUND") . "\n";
echo "Gudang: " . ($gudang ? "FOUND ($gudang->email)" : "NOT FOUND") . "\n";

if ($manager) {
    echo "\nTesting Project Creation for Manager...\n";
    $project = Project::create([
        'nama_proyek' => 'Verification Project',
        'lokasi' => 'Test Site',
        'tanggal_mulai' => now(),
        'tanggal_selesai' => now()->addDays(30),
        'manager_id' => $manager->id,
        'progres' => 0
    ]);
    echo "Project created ID: " . $project->id . "\n";
    
    $p = Project::with('manager')->find($project->id);
    echo "Relationship check (Manager Name): " . $p->manager->name . "\n";
    
    $count = Project::where('manager_id', $manager->id)->count();
    echo "Total projects for this manager: $count\n";
}

echo "\n--- VERIFICATION COMPLETE ---\n";
