<?php

namespace App\Modules\VatTaxSetting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatTaxSetting extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $fillable=[
        'title',
       'vat_percent',
       'is_default',
       'maximum_amount',
       'status',
       'created_at',
       'created_by',
       'updated_at',
       'updated_by',
       'deleted',
       'deleted_at',
       'deleted_by',
    ];
}
