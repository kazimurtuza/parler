<?php

namespace App\Modules\ProductInventory\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\Employee;
use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    public $timestamps=false;
    use HasFactory;
    protected $fillable=[
        'branch_id',
        'transaction_type',
        'product_requisition_id',
        'product_requisition_details_id',
        'employee_id',
        'product_id',
        'quantity',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }  public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}
