<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'material_id',
        'jumlah_kebutuhan',
        'jumlah_dialokasikan', // On the way
        'jumlah_tersedia',     // At site
        'total_diterima',      // Cumulative sent
        'sisa_kebutuhan'
    ];

    protected static function booted()
    {
        static::saving(function ($projectMaterial) {
            $projectMaterial->sisa_kebutuhan = max(0, $projectMaterial->jumlah_kebutuhan - $projectMaterial->total_diterima);
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
