<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings;

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

    // public function settings()
    // {
    //     return $this->belongsTo(Settings::class);
    //     // return $this->belongsTo('App\Models\Settings');
    // }

    public function getCoolName1Attribute()
    {
        return $this->attributes['kilometer'];
    }

    public function getAgeAttribute($value)
    {
        return $this->attributes['kilometer'];
    }

    // public function settings()
    // {
    //     return Settings::where('id', 1)->get();
    // }

    
}
