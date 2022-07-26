<?php

namespace App\Modules\Service\Models;

use App\Modules\BranchService\Models\BranchService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
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
        'default_image'
    ];
    public function branchService(){
        return $this->hasMany(BranchService::class,'service_id','id');
    }

    public function getDiscountTypeTextAttribute()
    {
        $array = [
            0 => 'Fixed',
            1 => 'Percentage '
        ];
        return $array[$this->discount_type] ?? '';
    }

    public function getDefaultImageAttribute()
    {
        if (($this->image == null) || ($this->image == '')) {
            return 'assets/service-default.png';
        }
        return $this->image;
    }
}
