<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Settings;


// use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Route extends Model
{
    use HasFactory;
    protected $table = "routes";

    protected $fillable = [
        'user_id',
        'load_address_id',
        'unload_address_id',
        'return_address_id',
        'kilometer',
        'cost_tollbooth',
        'cost_pemex',
        'cost_pension',
        'cost_food',
        'cost_hotel'
    ];


    public function load_address()
    {
        return $this->belongsTo(Address::class, 'load_address_id');
    }

    public function unload_address()
    {
        return $this->belongsTo(Address::class, 'unload_address_id');
    }

    public function return_address()
    {
        return $this->belongsTo(Address::class, 'return_address_id');
    }
}
