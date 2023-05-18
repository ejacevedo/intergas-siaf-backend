<?php

namespace Database\Seeders;

// use App\Models\Role;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

use App\Constants\Roles;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            "name" => Roles::ROOT,
        ]);

        Role::create([
            "name" => Roles::ADMIN_QUOTE,
        ]);

        Role::create([
            "name" => Roles::QUOTE,
        ]);
    }
}
