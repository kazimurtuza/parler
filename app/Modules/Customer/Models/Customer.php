<?php

namespace App\Modules\Customer\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\CustomerMembership\Models\CustomerMembership;
use App\Modules\CustomerWallet\Models\CustomerWallet;
use App\Modules\Invoice\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected  $fillable=[
        'branch_id',
        'customer_membership_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'available_balance',
        'photo',
        'dob',
        'gender',
        'blood',
        'can_due',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    protected $appends = [
        'full_name',
        'default_photo'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getDefaultPhotoAttribute()
    {
        if (($this->photo == null) || ($this->photo == '')) {
            return 'assets/employee-default.png';
        }
        return $this->photo;
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function membership(){
        return $this->belongsTo(CustomerMembership::class,'customer_membership_id','id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id', 'id');
    }

    public function customerWallets()
    {
        return $this->hasMany(CustomerWallet::class, 'customer_id', 'id');
    }

    public function customerInWallets()
    {
        return $this->hasMany(CustomerWallet::class, 'customer_id', 'id')->where('type', 'in');
    }
}
