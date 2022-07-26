<?php

namespace App\Modules\ProductRequisition\Models;

use App\Models\User;
use App\Modules\Branch\Models\Branch;
use App\Modules\Product\Models\Product;
use App\Modules\ProductRequisitionDetails\Models\ProductRequisitionDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequisition extends Model
{
    public $timestamps=false;
    use HasFactory;
    protected $fillable=[
        'requisition_no',
        'branch_id',
        'requested_by',
        'total_amount',
        'approve_status',
        'approve_by',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted ',
        'deleted_at',
        'deleted_by',
    ];

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');

    }
    public function user(){
        return $this->belongsTo(User::class,'requested_by','id');

    }

    public function details(){
        return $this->hasMany(ProductRequisitionDetails::class,'product_requisition_id','id');
    }

    protected $appends=['approve_status_text'];
    function getApproveStatusTextAttribute()
    {

        $array=[
            '0'=>'Pending',
            '1'=>'Approved',
            '2'=>'Rejected',
            '3'=>'purchased',
        ];
        return $array[$this->approve_status];

    }

}
