<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJob;
use Illuminate\Http\Request;
use App\Job;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('priority', 'DESC')->get()->groupBy('processor_id');

        return  response()->json(['data' =>  $jobs]);
    }

    public function store(StoreJob $request)
    {
        $user = Auth()->user();

        if (!$user->isSubmitter()) {
            return  response()->json(['message' => 'You are not a submitter entity']);
        }

        $created = $user->submits()->createMany($request->jobs);

        return  response()->json(['data' =>  $created]);
    }

    public function update(Request $request)
    {
        $user = Auth()->user();
        $job = $user->submits()->find($request->id);

        $job = Job::find($request->id);

        if (is_null($job)) {
            return  response()->json(['message' => 'Job not found']);
        }

        $job->fill($request->all());
        $job->save();

        return  response()->json(['data' => $job]);
    }

    public function nextJob()
    {
        $user = Auth()->user();

        if (!$user->isProcessor()) {
            return  response()->json(['message' => 'You are not a processor entity']);
        }

        if ($user->isBusy()) {
            return  response()->json(['message' => 'You already have a process assigned']);
        }

        $job = $user->process()->where('status_id', 1)
            ->orderBy('priority', 'DESC')
            ->first();

        if (is_null($job)) {
            return  response()->json(['message' => 'No process found to assign']);
        }else{
            $job->status_id = 1;
            $job->save();
            $user->busy = true;
            $user->save();
        }

        return  response()->json(['data' => $job]);
    }

    public function status(Request $request)
    {
        $job = Job::with('status')->find($request->id);

        if (is_null($job)) {
            return  response()->json(['message' => 'No process found']);
        }

        return  response()->json(['message' => $job->status->name]);
    }

    public function finishJob(Request $request)
    {
        $user = Auth()->user();

        $job = $user->process()->where(['status_id' => 1])->find($request->id);

        if (is_null($job)) {
            return  response()->json(['message' => 'Process not found']);
        }

        $job->status_id = 2;
        $job->save();
        $user->busy = false;
        $user->save();

        return  response()->json(['message' => 'Process finished']);
    }
}
