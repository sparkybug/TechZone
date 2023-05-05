<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $jobs = Job::all();

        // return $jobs;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'job_tag' => 'required',
            'skill_set' => 'required',
            'work_period' => 'required',
            'budget_des' => 'required',
            'budget' => 'required|numeric',
            'job_des' => 'required',
        ]);

        $job = new Job;

        $job->job_tag = $validatedData['job_tag'];
        $job->skill_set = $validatedData['skill_set'];
        $job->work_period = $validatedData['work_period'];
        $job->budget_des = $validatedData['budget_des'];
        $job->budget = $validatedData['budget'];
        $job->job_des = $validatedData['job_des'];

        $job->save();

        return response()->json([
            'message' => 'Job posted successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jobs $jobs)
    {
        //
        // return Job::findOrAbort($jobs);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jobs $jobs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jobs $jobs)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jobs $jobs)
    {
        //
    }
}
