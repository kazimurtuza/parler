<?php

namespace App\Modules\Accounts\Models;

use App\Modules\BankAccount\Models\BankAccount;
use App\Modules\Branch\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;

    public  $timestamps=false;
    protected  $fillable=[
        'transaction_no',
        'type',
        'type_description',
        'branch_id',
        'reference',
        'reference_id',
        'bank_account_id',
        'datetime',
        'amount',
        'note',
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
    }
    public function bank(){
        return $this->belongsTo(BankAccount::class,'bank_account_id','id');
    }
}
