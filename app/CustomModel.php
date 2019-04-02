<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomModel extends Model
{
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
