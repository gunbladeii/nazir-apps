<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstrumentRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('instrument_role')->insert([
            ['type' => 'Sekolah Rendah'],
            ['type' => 'Sekolah Menengah'],
            // Add more types as necessary
        ]);
        
    }
}
