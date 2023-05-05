<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function location_a(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'point_a_location_id');
    }

    public function location_b(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'point_b_location_id');
    }

    public function location_c(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'point_c_location_id');
    }
    

    // public function settings()
    // {
    //     return Settings::where('id', 1)->get();
    // }

    
}
