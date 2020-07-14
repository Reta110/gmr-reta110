<?php

use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $submitter = factory(App\User::class)->make([
            "type" => 'submitter'
        ]);

        $processor = factory(App\User::class)->make([
            "type" => 'processor'
        ]);

        factory(App\Job::class, 1000)->make([
            'user_id' => $submitter->id,
            'processor_id' => $processor->id
        ]);
    }
}
