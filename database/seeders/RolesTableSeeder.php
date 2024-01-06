<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Create roles
    $adminRole = Role::create(['name' => 'admin']);
    $userRole = Role::create(['name' => 'user']);

    // Assign roles to users
    $adminUser = User::find(1);
    if ($adminUser) {
        $adminUser->roles()->attach($adminRole);
    } else {
        // User with ID 1 not found, handle accordingly
    }

    $normalUser = User::find(2);
    if ($normalUser) {
        $normalUser->roles()->attach($userRole);
    } else {
        // User with ID 2 not found, handle accordingly
    }

        }
}
