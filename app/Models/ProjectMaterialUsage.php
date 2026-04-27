<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMaterialUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_progress_update_id',
        'material_id',
        'quantity_used',
    ];

    public function progressUpdate()
    {
        return $this->belongsTo(ProjectProgressUpdate::class, 'project_progress_update_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
