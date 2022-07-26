<?php

namespace App\Modules\Branch\Models;

use App\Modules\Invoice\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'branches';

    protected $fillable = [
        'name',
        'contact_phone',
        'address',
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

    public function sale(){
        return $this->hasMany(Invoice::class,'branch_id','id');
    }
}
