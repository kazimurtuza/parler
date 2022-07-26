<?php

namespace App\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchProduct extends Model
{
    use HasFactory;

    protected $table = 'branch_products';
    public $timestamps = false;
    protected $fillable = [
        'branch_id',
        'product_id',
        'total_qty',
        'used_qty',
        'available_qty',
    ];

    public function details(){

        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
}
