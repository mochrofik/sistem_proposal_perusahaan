<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    $division = \App\Models\Division::get(); 
    

        User::updateOrCreate([
            'name' => 'Manager',
            'email' => 'manager@mail.com',
            'password' => Hash::make('manager123'),
            'division_id' => $division->random()->id,
        ])->assignRole('Manager');

        User::updateOrCreate([
            'name' => 'Finance',
            'email' => 'finance@mail.com',
            'password' => Hash::make('finance123'),
            'division_id' => $division->random()->id,
        ])->assignRole('Finance');
    }
}
