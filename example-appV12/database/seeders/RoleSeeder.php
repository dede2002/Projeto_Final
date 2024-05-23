<?php

// database/seeders/RoleSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Secretária']);
        Role::create(['name' => 'Psicólogo']);
        Role::create(['name' => 'Cliente']);
    }
}
