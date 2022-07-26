<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected  $fillable=[
         'name',
         'image',
         'price',
         'note',
         'status',
         'created_at',
         'created_by',
         'updated_at',
         'updated_by',
         'deleted',
         'deleted_at',
         'deleted_by'
    ];

    protected $appends = [
        'default_image'
    ];

    public function getDefaultImageAttribute()
    {
        if (($this->image == null) || ($this->image == '')) {
            return 'assets/product-default.png';
        }
        return $this->image;
    }
}
