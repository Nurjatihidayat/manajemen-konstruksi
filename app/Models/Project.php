<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_id',
        'nama_proyek',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_proyek',
        'progres'
    ];

    public function projectMaterials()
    {
        return $this->hasMany(ProjectMaterial::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function progressUpdates()
    {
        return $this->hasMany(ProjectProgressUpdate::class)->latest();
    }
}
