<?php

namespace App\Modules\InvoiceDetails\Models;

use App\Modules\BranchService\Models\BranchService;
use App\Modules\Employee\Models\Employee;
use App\Modules\Service\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;
    protected $fillable=[
        'invoice_id',
        'branch_id',
        'employee_id',
        'service_id',
        'unit_price',
        'quantity',
        'discount_type',
        'discount_value',
        'discount_amount',
        'total_price',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    public function service(){
        return $this->belongsTo(BranchService::class,'service_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}
