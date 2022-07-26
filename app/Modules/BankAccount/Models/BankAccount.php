<?php

namespace App\Modules\BankAccount\Models;

use App\Modules\Accounts\Models\TransactionHistory;
use App\Modules\Branch\Models\Branch;
use App\Modules\CustomerWallet\Models\CustomerWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
       'account_no',
       'branch_id',
       'opening_balance',
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

    public function bankBalance(){
        return $this->hasMany(TransactionHistory::class,'bank_account_id','id');
    }
}
