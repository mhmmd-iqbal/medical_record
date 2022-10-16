<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Queue extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'queues';

    protected $fillable = [
        'patient_id',
        'poliklinik_id',
        'queue_no',
        'medical_issue',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $cast = [
        'queue_no'      => 'integer',
        'created_at'    => 'date:Y-m-d H:i:s',
        'updated_at'    => 'date:Y-m-d H:i:s',
        'deleted_at'    => 'date:Y:m:d H:i:s',
    ];

    protected $hidden = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'poliklinik_id', 'id');
    }
}
