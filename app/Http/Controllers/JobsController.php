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
        $this->validate($request, [
            'job_tag' => 'required',
            'skill_set' => 'required',
            'work_period' => 'required',
            'budget_des' => 'required',
            'budget' => 'required|numeric',
            'job_des' => 'required',
        ]);

        $job = Jobs::create([
            'job_tag' => $request->job_tag,
            'skill_set' => $request->skill_set,
            'work_period' => $request->work_period,
            'budget_des' => $request->budget_des,
            'budget' => $request->budget,
            'job_des' => $request->job_des,
        ]);

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
