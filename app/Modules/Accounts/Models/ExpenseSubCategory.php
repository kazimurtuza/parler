<?php

namespace App\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_category_id',
        'name',
        'status',
        'is_product_purchase',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    public function category(){
        return $this->belongsTo(ExpenseCategory::class,'expense_category_id','id');
    }
}
