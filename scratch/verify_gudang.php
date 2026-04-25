<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Project;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

echo "--- GUDANG ROLE VERIFICATION ---\n";

$gudang = User::where('role', 'gudang')->first();
if (!$gudang) {
    die("Gudang user not found.\n");
}

Auth::login($gudang);
echo "Logged in as: " . Auth::user()->name . " (Role: " . Auth::user()->role . ")\n";

$assignedProject = Project::find($gudang->assigned_project_id);
if (!$assignedProject) {
    echo "Warning: Gudang user not assigned to any project. Assigning to the first available project...\n";
    $assignedProject = Project::first();
    $gudang->update(['assigned_project_id' => $assignedProject->id]);
}

echo "Assigned Project: " . $assignedProject->nama_proyek . "\n";

// 1. Create Material
echo "\nTesting Create Material...\n";
$material = $assignedProject->materials()->create([
    'nama_material' => 'Test Material Gudang',
    'jumlah_tersedia' => 100,
    'jumlah_kebutuhan' => 200,
]);
echo "Material Created: " . $material->nama_material . " (ID: $material->id)\n";

// 2. Edit Material
echo "\nTesting Edit Material...\n";
$material->update(['jumlah_tersedia' => 150]);
echo "Material Updated. New Stock: " . $material->jumlah_tersedia . "\n";

// 3. Delete Material
echo "\nTesting Delete Material...\n";
$materialId = $material->id;
$material->delete();
$exists = Material::find($materialId);
echo "Material Deleted: " . ($exists ? "FAILED" : "SUCCESS") . "\n";

echo "\n--- GUDANG VERIFICATION COMPLETE ---\n";
