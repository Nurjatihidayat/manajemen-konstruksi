<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_order_id','material_id','quantity','price'];
    public function purchaseOrder() { return $this->belongsTo(PurchaseOrder::class); }
    public function material()      { return $this->belongsTo(Material::class); }
}
