<?php

namespace App\Modules\Employee\Models;

use App\Models\User;
use App\Modules\Branch\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable=[
        'type',
        'user_id',
        'branch_id',
        'salary_type',
        'salary_value',
        'joining_date',
        'address',
        'employees',
        'nid_number',
        'photo',
        'dob',
        'blood',
        'gender',
        'marital_status',
        'permanent_address',
        'employee_id',
        'contact_person_name',
        'contact_person_number',
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
        'salary_type_text',
        'gender_text',
        'default_photo'
    ];

    function user(){
       return $this->belongsTo(User::class,'user_id','id');
    }

    function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
    public function getSalaryTypeTextAttribute()
    {
        $array = [
            0 => 'Commission Based',
            1 => 'Salary Based'
        ];
        return $array[$this->salary_type] ?? '';
    }

    public function getGenderTextAttribute($key)
    {
        $array=[
            0=>'Male',
            1=>'Female',
            2=>'Others',
        ];

        return $array[$this->gender] ?? '-';
    }

    public function getDefaultPhotoAttribute()
    {
        if (($this->photo == null) || ($this->photo == '')) {
            return 'assets/employee-default.png';
        }
        return $this->photo;
    }
}
