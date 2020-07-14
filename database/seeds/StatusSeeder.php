<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'id' => 1,
            'name' => 'Pending',
        ]);

        DB::table('status')->insert([
            'id' => 2,
            'name' => 'Processing',
        ]);

        DB::table('status')->insert([
            'id' => 3,
            'name' => 'Finished',
        ]);
    }
}
