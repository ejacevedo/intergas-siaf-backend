<?php

namespace App\Models;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;


use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $appends = ['label'];    

    public function getLabelAttribute()
    {
        $name = Lang::get('roles.' . $this->name);
        return Str::title($name );
    }
}