<?php

namespace App\Modules\CustomerMembership\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMembership extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected  $fillable=[
         'title',
         'discount_type',
         'discount_value',
         'icon',
         'is_default',
         'status',
         'created_at',
         'created_by',
         'updated_at',
         'updated_by',
         'deleted',
         'deleted_at',
         'deleted_by',
    ];
    protected  $appends=[
        'discount_type_text',
        'default_icon'
    ];
    public function getDiscountTypeTextAttribute()
    {
        $array=[
            '0'=>'Fixed',
            '1'=>'Percentage',
        ];
        return $array[$this->discount_type];
    }
    public function getDefaultIconAttribute()
    {
        if (($this->icon == null) || ($this->icon == '')) {
            return 'assets/membership-icon-default.png';
        }
        return $this->icon;
    }
}
