<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAnalytic extends Model
{
    protected $fillable = [
        'product_id',
        'year',
        'month',
        'clicks',
    ];
}
