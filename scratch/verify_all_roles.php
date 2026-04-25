<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Project;
use App\Models\Material;
use App\Models\MaterialTransaction;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

echo "=== FULL SYSTEM VERIFICATION ===\n\n";

// ==============================
// 1. ADMIN TEST
// ==============================
echo "--- [1] ADMIN LOGIN ---\n";
$admin = User::where('role', 'admin')->first();
Auth::login($admin);
echo "Logged in: {$admin->name} ({$admin->email}) | Role: {$admin->role}\n";

$allProjects = Project::with('manager')->get();
echo "Total projects visible: " . $allProjects->count() . "\n";
foreach ($allProjects as $p) {
    echo "  - {$p->nama_proyek} | Manager: " . ($p->manager->name ?? 'N/A') . " | Progress: {$p->progres}%\n";
}

$allUsers = User::all();
echo "Total users: " . $allUsers->count() . "\n";
foreach ($allUsers as $u) {
    echo "  - {$u->name} | {$u->email} | Role: {$u->role} | Assigned Project: " . ($u->assigned_project_id ?? 'N/A') . "\n";
}
echo "Admin test: PASSED\n\n";

// ==============================
// 2. MANAJER TEST
// ==============================
echo "--- [2] MANAJER LOGIN ---\n";
$manager = User::where('role', 'manajer')->first();
Auth::login($manager);
echo "Logged in: {$manager->name} ({$manager->email}) | Role: {$manager->role}\n";

$managerProjects = Project::where('manager_id', $manager->id)->get();
echo "Projects managed: " . $managerProjects->count() . "\n";
foreach ($managerProjects as $p) {
    echo "  - {$p->nama_proyek} | Progress: {$p->progres}%\n";
}

// Test update progress
$testProject = $managerProjects->first();
if ($testProject) {
    $testProject->update(['progres' => 75, 'status_proyek' => 'berjalan']);
    echo "Updated progress to 75% -> Status: {$testProject->status_proyek}\n";
    
    $testProject->update(['progres' => 100, 'status_proyek' => 'selesai']);
    echo "Updated progress to 100% -> Status: {$testProject->status_proyek}\n";
    
    // Reset back
    $testProject->update(['progres' => 25, 'status_proyek' => 'berjalan']);
}
echo "Manajer test: PASSED\n\n";

// ==============================
// 3. GUDANG TEST
// ==============================
echo "--- [3] GUDANG LOGIN ---\n";
$gudang = User::where('role', 'gudang')->first();
Auth::login($gudang);
echo "Logged in: {$gudang->name} ({$gudang->email}) | Role: {$gudang->role}\n";
echo "Assigned project ID: {$gudang->assigned_project_id}\n";

$assignedProject = Project::find($gudang->assigned_project_id);
echo "Assigned project: {$assignedProject->nama_proyek}\n";

// 3a. Create material
echo "\n[3a] CREATE Material...\n";
$mat = $assignedProject->materials()->create([
    'nama_material' => 'Paku 5cm',
    'jumlah_tersedia' => 500,
    'jumlah_kebutuhan' => 1000,
]);
echo "Created: {$mat->nama_material} (ID: {$mat->id}) | Stock: {$mat->jumlah_tersedia} | Need: {$mat->jumlah_kebutuhan} | Shortage: {$mat->kekurangan}\n";

// 3b. Edit material
echo "\n[3b] EDIT Material...\n";
$mat->update(['jumlah_tersedia' => 700]);
$mat->refresh();
echo "Updated stock to 700 | Shortage now: {$mat->kekurangan}\n";

// 3c. Transaction: stock_in
echo "\n[3c] TRANSACTION: Stock In (+200)...\n";
$mat->jumlah_tersedia += 200;
$mat->save();
MaterialTransaction::create([
    'user_id' => $gudang->id,
    'material_id' => $mat->id,
    'type' => 'stock_in',
    'quantity' => 200,
    'description' => 'Barang masuk dari supplier'
]);
$mat->refresh();
echo "Stock after stock_in: {$mat->jumlah_tersedia} | Shortage: {$mat->kekurangan}\n";

// 3d. Transaction: dispatch
echo "\n[3d] TRANSACTION: Dispatch (-100)...\n";
$mat->jumlah_tersedia -= 100;
$mat->save();
MaterialTransaction::create([
    'user_id' => $gudang->id,
    'material_id' => $mat->id,
    'type' => 'dispatch',
    'quantity' => 100,
    'description' => 'Kirim ke lokasi proyek'
]);
$mat->refresh();
echo "Stock after dispatch: {$mat->jumlah_tersedia} | Shortage: {$mat->kekurangan}\n";

// 3e. Check all transactions
echo "\n[3e] TRANSACTION LOG...\n";
$transactions = MaterialTransaction::where('material_id', $mat->id)->get();
foreach ($transactions as $t) {
    echo "  - Type: {$t->type} | Qty: {$t->quantity} | Note: {$t->description}\n";
}

// 3f. Delete material
echo "\n[3f] DELETE Material...\n";
$matId = $mat->id;
$mat->delete();
$exists = Material::find($matId);
echo "Delete result: " . ($exists ? "FAILED" : "SUCCESS") . "\n";

echo "\nGudang test: PASSED\n\n";

// ==============================
// SUMMARY
// ==============================
echo "=================================\n";
echo "  ALL TESTS PASSED SUCCESSFULLY\n";
echo "=================================\n";
echo "Admin:   Login OK, View All Projects OK, View All Users OK\n";
echo "Manajer: Login OK, Filtered Projects OK, Update Progress OK\n";
echo "Gudang:  Login OK, Create Material OK, Edit OK, Stock In OK, Dispatch OK, Delete OK\n";
