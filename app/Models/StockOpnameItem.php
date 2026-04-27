<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameItem extends Model
{
    use HasFactory;
    protected $fillable = ['stock_opname_id','material_id','system_stock','physical_stock','difference','notes'];
    public function stockOpname() { return $this->belongsTo(StockOpname::class); }
    public function material()    { return $this->belongsTo(Material::class); }
}
