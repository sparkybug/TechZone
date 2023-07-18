<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AssignedJobs;
use App\Models\Jobs;
use App\Models\User;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function assignJobs(Request $request)
    {
        $validatedData = $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $job = Jobs::findOrFail($validatedData['job_id']);

        $job->assignedUsers()->attach($validatedData['user_id']);

        return response()->json([
            'message' => 'Job assigned successfully'
        ]);
    }

    public function getUserJobs(Request $request, User $user)
    {
        $jobs = AssignedJobs::where('user_id', $user->id)->get();
        return response()->json($jobs, 200);
    }
}
