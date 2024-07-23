<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('schools')->insert([
            'name' => Str::random(10),
            'address' => Str::random(20),
            'school_registration_number' => Str::random(10),
            'representative_email' => Str::random(10) . '@example.com',
            'representative_name' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
