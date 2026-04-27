<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectProgressUpdate extends Model
{
    use HasFactory;
    protected $fillable = ['project_id','manager_id','progress_percentage','description','photo_path','date'];
    public function project() { return $this->belongsTo(Project::class); }
    public function manager() { return $this->belongsTo(User::class, 'manager_id'); }
    public function materialUsages() { return $this->hasMany(ProjectMaterialUsage::class, 'project_progress_update_id'); }
}
