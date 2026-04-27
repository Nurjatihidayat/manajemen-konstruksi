<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number', 'project_id', 'manager_id',
        'status', 'request_date', 'notes',
    ];

    public function project()   { return $this->belongsTo(Project::class); }
    public function manager()   { return $this->belongsTo(User::class, 'manager_id'); }
    public function items()     { return $this->hasMany(MaterialRequestItem::class); }
}
