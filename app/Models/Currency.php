<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    protected $guarded = [];

    public function products():HasMany{
        return $this->hasMany(Product::class);
    }
}
