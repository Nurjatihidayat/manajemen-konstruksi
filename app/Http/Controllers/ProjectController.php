<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\ActivityLog;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role == 'admin') {
            $projects = Project::with('manager')->get();
        } elseif ($user->role == 'gudang') {
            $projects = Project::with('manager')->where('id', $user->assigned_project_id)->get();
        } else { // manajer
            $projects = Project::with('manager')->where('manager_id', $user->id)->get();
        }
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $managers = User::where('role', 'manajer')->get();
        return view('projects.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'manager_id' => 'required|exists:users,id',
            'progres' => 'nullable|integer|min:0|max:100',
        ]);

        $data = $request->all();
        $data['status_proyek'] = ($request->progres == 100) ? 'selesai' : 'berjalan';

        $project = Project::create($data);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Membuat proyek baru: ' . $project->nama_proyek
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(string $id)
    {
        $project = Project::with(['projectMaterials.material', 'manager'])->findOrFail($id);

        if (auth()->user()->role == 'gudang' && $project->id != auth()->user()->assigned_project_id) {
            abort(403, 'Akses ditolak. Anda tidak ditugaskan di proyek ini.');
        }

        return view('projects.show', compact('project'));
    }

    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        $managers = User::where('role', 'manajer')->get();
        return view('projects.edit', compact('project', 'managers'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_proyek' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'progres' => 'nullable|integer|min:0|max:100',
            'manager_id' => 'required|exists:users,id',
        ]);

        $project = Project::findOrFail($id);
        
        // Authorization check
        if (auth()->user()->role == 'manajer' && $project->manager_id != auth()->id()) {
            abort(403);
        }

        $data = $request->all();
        if (isset($data['progres'])) {
            $data['status_proyek'] = ($data['progres'] == 100) ? 'selesai' : 'berjalan';
        }

        $project->update($data);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Memperbarui proyek: ' . $project->nama_proyek
        ]);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        if (auth()->user()->role == 'gudang' || auth()->user()->role == 'manajer') {
            abort(403, 'Anda tidak memiliki wewenang untuk menghapus proyek.');
        }

        $nama = $project->nama_proyek;
        $project->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Menghapus proyek: ' . $nama
        ]);

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
