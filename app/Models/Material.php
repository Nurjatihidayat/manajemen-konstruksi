<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'nama_material',
        'jumlah_tersedia',
        'jumlah_kebutuhan',
        'kekurangan'
    ];

    protected static function booted()
    {
        static::saving(function ($material) {
            $material->kekurangan = $material->jumlah_kebutuhan - $material->jumlah_tersedia;
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
