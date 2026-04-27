<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectProgressUpdate;
use App\Models\Project;
use App\Models\ActivityLog;

class ProjectProgressController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $user = auth()->user();
        if ($user->role != 'manajer' && $user->role != 'admin') abort(403);
        if ($user->role == 'manajer' && $project->manager_id != $user->id) abort(403);

        $request->validate([
            'progress_percentage' => 'required|numeric|min:0|max:100',
            'description'         => 'required|string',
            'date'                => 'required|date',
            'photo'               => 'nullable|image|max:2048',
        ]);

        // Batasan Manager: wajib update sebelum lanjut hari berikutnya (we just allow, description is required)
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('progress_photos', 'public');
        }

        $update = ProjectProgressUpdate::create([
            'project_id'          => $project->id,
            'manager_id'          => $user->id,
            'progress_percentage' => $request->progress_percentage,
            'description'         => $request->description,
            'photo_path'          => $photoPath,
            'date'                => $request->date,
        ]);

        // Process material usage if provided
        if ($request->has('materials')) {
            foreach ($request->materials as $matData) {
                if (isset($matData['material_id']) && isset($matData['quantity']) && $matData['quantity'] > 0) {
                    $material_id = $matData['material_id'];
                    $qty = $matData['quantity'];

                    // Record usage
                    \App\Models\ProjectMaterialUsage::create([
                        'project_progress_update_id' => $update->id,
                        'material_id' => $material_id,
                        'quantity_used' => $qty,
                    ]);

                    // Deduct from project-level available stock
                    $projectMat = $project->projectMaterials()->where('material_id', $material_id)->first();
                    if ($projectMat) {
                        $projectMat->jumlah_tersedia = max(0, $projectMat->jumlah_tersedia - $qty);
                        $projectMat->save();
                    }
                }
            }
        }

        // Update project progress to the latest value
        $project->update(['progres' => $request->progress_percentage]);

        ActivityLog::create([
            'user_id'     => $user->id,
            'description' => 'Update progres proyek ' . $project->nama_proyek . ' menjadi ' . $request->progress_percentage . '% serta mencatat pemakaian material.',
        ]);

        return back()->with('success', 'Update progres dan pemakaian material berhasil disimpan.');
    }
}
