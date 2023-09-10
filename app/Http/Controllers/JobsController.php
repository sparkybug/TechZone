<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jobs;
use App\Models\SavedJobs;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $jobs = Jobs::all();

        return $jobs;
    }

    /**
     * Function for saved jobs.
     */
    public function save(Request $request, $id)
    {
        // Find the job by ID
        $jobs = Jobs::findOrFail($id);

        //  Save the job to the database
        $saved = $request->user()->savedJobs()->toggle($jobs);

        if($saved->contains($jobs)) {
            return response()->json(['message' => 'Job saved successfully']);
        } else {
            return response()->json(['message' => 'Job removed from saved']);
        }
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

        $user = Auth::user();
        
        SavedJobs::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
        ]);

        return response()->json([
            'message' => 'Job posted successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jobs $jobs, $id)
    {
        // Retrieve a specific job by ID
        $job = Jobs::findOrFail($id);

        return response()->json($job);
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
    public function update(Request $request, $id)
    {
        // Update a specific job by ID
        $job = Jobs::findOrFail($id);
        $job->update($request->all());

        return response()->json($job);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jobs $jobs, $id)
    {
        // Dlelete a specific job by ID
        $job = Jobs::findOrFail($id);
        $job->delete();

        return response()->json(null, 204);
    }

    public function getSavedJobsPerUser(Request $request, User $user)
    {
        $savedJobs = $user->savedJobs()->with('job')->get();
        return response()->json($savedJobs, 200);
    }

    // public function getAllSavedJobs(Request $request)
    // {
    //     $savedJobs = $user->savedJobs()->with('job')->get();
    //     return response()->json($savedJobs, 200);
    // }
}
