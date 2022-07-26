<?php

namespace App\Modules\ProductRequisitionDetails\Models;

use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequisitionDetails extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected  $fillable=[
        'product_requisition_id',
        'product_id',
        'unit_price',
        'quantity',
        'total_amount',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];
    public  function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
