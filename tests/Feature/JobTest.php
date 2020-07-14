<?php

namespace Tests\Feature;

use App\Job;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class JobTest extends TestCase
{
    use WithFaker;

    /**
     * Jobs can be listed.
     * @throws \Exception
     */
    public function test_jobs_can_be_listed()
    {
        $user = factory(User::class)->create([
            'type' => 'submitter',
        ]);

        Passport::actingAs($user);

        $response = $this->get('/api/jobs');

        $response->assertStatus(200);
    }


    /**
     * Jobs can be created.
     *
     * @throws \Exception
     */
    public function test_jobs_can_be_created()
    {
        $submitter = factory(User::class)->create([
            'type' => 'submitter',
        ]);

        $processor = factory(User::class)->create([
            'type' => 'processor',
        ]);

        Passport::actingAs($submitter);

        $data['jobs'] =  factory(Job::class, 3)->make([
            'processor_id' => $processor->id,
        ])->toArray();

        $this->actingAs($submitter)->postJson('/api/jobs', $data)
            ->assertStatus(200);
    }

    /**
     * Jobs can be updated.
     *
     * @throws \Exception
     */
    public function test_jobs_can_be_updated()
    {
        $submitter = factory(User::class)->create([
            'type' => 'submitter',
        ]);

        $processor = factory(User::class)->create([
            'type' => 'processor',
        ]);

        Passport::actingAs($submitter);

        $data = factory(Job::class)->make(['processor_id' => $processor->id])->toArray();
        $job = $submitter->submits()->create($data);
            
        $this->actingAs($submitter)->putJson('/api/jobs/'. $job->id, ['title' => 'New title']);

        $this->assertDatabaseHas(
            'jobs',
            [
                'id' => $job->id,
                'title' => 'New title'
            ]
        );
    }

    /**
     * Jobs can be deleted.
     *
     * @throws \Exception
     */
    public function test_processor_always_take_highest_priority()
    {
        $submitter = factory(User::class)->create([
            'type' => 'submitter',
        ]);

        $processor = factory(User::class)->create([
            'type' => 'processor',
        ]);

        Passport::actingAs($submitter);

        $data = factory(Job::class)->make([
            'priority' => 1000,
            'processor_id' => $processor->id,
        ])->toArray();
        $submitter->submits()->create($data);

        $data['jobs'] = factory(Job::class, 50)->make([
            'priority' => rand(0,99),
            'processor_id' => $processor->id,
        ])->toArray();

        $submitter->submits()->create($data);

        $response = $this->actingAs($processor)->get('/api/next')
        ->assertStatus(200);
        
        $response->assertJsonFragment([
            'priority' => 1000
        ]);
    }
}
