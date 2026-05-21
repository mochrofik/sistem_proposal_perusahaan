<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $divisions = ['Divisi 1', 'Divisi 2', 'Divisi 3', 'Divisi 4', 'Divisi 5'];

        foreach ($divisions as $division) {
            Division::updateOrCreate(['name' => $division]);
        }
        
    }
}
