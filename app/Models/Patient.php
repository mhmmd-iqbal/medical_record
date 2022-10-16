<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'nik',
        'name',
        'date_of_birth',
        'gender',
        'phone',
        'created_at',
        'deleted_at',
        'updated_at'
    ];

    protected $cast = [
        'date_of_birth' => 'date:Y-m-d',
        'created_at'    => 'date:Y-m-d H:i:s',
        'updated_at'    => 'date:Y-m-d H:i:s',
        'deleted_at'    => 'date:Y:m:d H:i:s',
    ];
    protected $appends = ['age'];
    protected $hidden = [];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id', 'id');
    }

    public function queues()
    {
        return $this->hasMany(Queue::class, 'patient_id', 'id');
    }
}
