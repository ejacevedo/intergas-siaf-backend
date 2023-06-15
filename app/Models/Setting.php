<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = "settings";

    protected $fillable = [
        'price_sale',
        'density',
        'load_capacity_per_kilogram',
        'load_capacity_per_liter',
        'price_disel',
        'price_event'
    ];
}
