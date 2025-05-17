<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'service_time' => 'datetime',
        'image' => 'string',
    ];

    public function parts()
    {
        return $this->belongsToMany(Parts::class, 'service_parts', 'service_id', 'part_id');
    }
}
