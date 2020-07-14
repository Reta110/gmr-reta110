<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Submitters name',
            'email' => 'submitter@gmail.com',
            'password' => bcrypt('123456789'),
            'type' => 'submitter',
        ]);

        DB::table('users')->insert([
            'name' => 'Processors name',
            'email' => 'processor@gmail.com',
            'password' => bcrypt('123456789'),
            'type' => 'processor',
        ]);

    }
}
