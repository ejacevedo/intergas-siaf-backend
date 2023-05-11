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
        'price_kilogram',
        'price_liter',
        'price_disel',
        'price_event'
    ];
    
}