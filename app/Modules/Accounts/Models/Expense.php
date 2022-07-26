<?php

namespace App\Modules\Accounts\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public $timestamps=false;
    use HasFactory;
    protected $fillable=[
        'branch_id',
        'expense_category_id',
        'expense_sub_category_id',
        'employee_id',
        'datetime',
        'amount',
        'note',
        'purchase_requisition_id',
        'bank_account_id',
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
        return  $this->belongsTo(Branch::class,'branch_id','id');
    }
    public function category(){
        return  $this->belongsTo(ExpenseCategory::class,'expense_category_id','id');
    }
    public function subcategory(){
        return  $this->belongsTo(ExpenseSubCategory::class,'expense_sub_category_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}
