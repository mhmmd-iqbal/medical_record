<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineList extends Model
{
    use HasFactory;

    protected $table = 'medicine_lists';

    protected $fillable = [
        'medical_record_id',
        'stock_id',
        'quantity',
        'confirmed',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $cast = [
        'quantity'      => 'integer',
        'confirmed'     => 'boolean',
        'created_at'    => 'date:Y-m-d H:i:s',
        'updated_at'    => 'date:Y-m-d H:i:s',
        'deleted_at'    => 'date:Y:m:d H:i:s',
    ];

    protected $with = ['stock'];

    protected $hidden = [];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id', 'id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }
}
