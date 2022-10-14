<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $table = 'medical_records';

    protected $fillable = [
        'patient_id',
        'user_id',
        'medical_issue',
        'medical_handle',
        'treated_at',
        'treated_to',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $cast = [
        'treated_at'    => 'date:Y-m-d',
        'treated_to'    => 'date:Y-m-d',
        'created_at'    => 'date:Y-m-d H:i:s',
        'updated_at'    => 'date:Y-m-d H:i:s',
        'deleted_at'    => 'date:Y:m:d H:i:s',
    ];

    protected $hidden = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function medicineLists()
    {
        return $this->hasMany(MedicineList::class, 'medical_record_id', 'id');
    }
}
