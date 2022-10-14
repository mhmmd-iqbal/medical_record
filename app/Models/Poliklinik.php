<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poliklinik extends Model
{
    use HasFactory;

    protected $table = 'polikliniks';

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'created_at',
        'deleted_at',
        'updated_at'
    ];

    protected $cast = [
        'created_at'    => 'date:Y-m-d H:i:s',
        'updated_at'    => 'date:Y-m-d H:i:s',
        'deleted_at'    => 'date:Y:m:d H:i:s',
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function queues()
    {
        return $this->hasMany(Queue::class, 'poliklinik_id', 'id');
    }
}
