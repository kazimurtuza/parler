<?php

namespace App\Modules\BranchService\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\Service\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchService extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected  $fillable=[
        'branch_id',
        'service_id',
        'price',
        'discount_type',
        'discount_value',
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
        'discount_type_text',
        'name',
        'default_image',
    ];

    public function getNameAttribute()
    {
        return $this->service->name;
    }
    public function getDefaultImageAttribute()
    {
        return $this->service->default_image;
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
    public function service(){
        return $this->belongsTo(Service::class,'service_id','id');
    }


    public function getDiscountTypeTextAttribute()
    {
        $array = [
            0 => 'Fixed',
            1 => 'Percentage '
        ];
        return $array[$this->discount_type] ?? '';
    }



}
