<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $table = "quotes";

    protected $fillable = [
        'user_id',
        'point_a_location_id',
        'point_b_location_id',
        'point_c_location_id',
        'kilometer',
        'cost_tollbooth',
        'cost_pemex',
        'cost_pension',
        'cost_food',
        'cost_hotel'
    ];
    
}
