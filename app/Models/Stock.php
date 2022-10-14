<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $fillable = [
        'name',
        'quantity',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $cast = [
        'quantity'      => 'integer',
        'created_at'    => 'date:Y-m-d H:i:s',
        'updated_at'    => 'date:Y-m-d H:i:s',
        'deleted_at'    => 'date:Y:m:d H:i:s',
    ];

    protected $hidden = [];

    public function medicineLists()
    {
        return $this->hasMany(MedicineList::class, 'stock_id', 'id');
    }
}
