<?php

namespace App\Modules\CustomerWallet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerWallet extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'customer_wallets';

    protected $fillable = [
        'customer_id',
        'transaction_no',
        'type',
        'type_description',
        'reference',
        'reference_id',
        'branch_id',
        'datetime',
        'amount',
        'note',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'bank_account_id',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];


}
