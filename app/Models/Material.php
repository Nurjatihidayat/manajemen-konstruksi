<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_material',
        'nama_material',
        'satuan',
        'jumlah_tersedia',
        'min_stock',
        'max_stock',
        'reorder_point'
    ];

    public function projectMaterials()
    {
        return $this->hasMany(ProjectMaterial::class);
    }
}
