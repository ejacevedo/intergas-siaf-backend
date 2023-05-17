<?php

namespace Database\Seeders;

// use App\Models\Role;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

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
            "name" => "root",
        ]);

        Role::create([
            "name" => "admin quote",
        ]);

        Role::create([
            "name" => "quote",
        ]);
    }
}
