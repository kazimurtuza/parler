<?php

namespace App\Modules\Invoice\Models;

use App\Modules\BankAccount\Models\BankAccount;
use App\Modules\Branch\Models\Branch;
use App\Modules\Customer\Models\Customer;
use App\Modules\InvoiceDetails\Models\InvoiceDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $timestamps=false;
    use HasFactory;
    protected $fillable=[
        'invoice_no',
        'customer_id',
        'branch_id',
        'total_amount',
        'discount_type',
        'discount_value',
        'discount_amount',
        'payable_amount',
        'previous_wallet_balance',
        'payment_method',
        'paid_amount',
        'vat_percent',
        'vat_amount',
        'new_wallet_balance',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
    function details(){
        return $this->hasMany(InvoiceDetails::class,'invoice_id','id');
    }
    function paymentMethod(){
        return $this->belongsTo(BankAccount::class,'payment_method','id');
    }

    protected $appends=[
        'discount_type_text',
        'payment_method_text'
    ];
    function getDiscountTypeTextAttributes()
    {
        $array=[
            '0'=>'Fixed',
            '1'=>'Percentage ',
        ];
        return $array[$this->discount_type];

    }

    public function getPaymentMethodTextAttribute()
    {
        if ($this->paid_amount <= 0) {
            return "Wallet";
        }
        if ($this->paid_amount >= $this->payable_amount) {
            return $this->paymentMethod->name;
        }
        return $this->paymentMethod->name . " & Wallet";
    }
}
