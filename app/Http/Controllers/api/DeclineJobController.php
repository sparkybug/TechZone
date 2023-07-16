<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AssignedJobs;
use Illuminate\Http\Request;

class DeclineJobController extends Controller
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

    public function declineJob(Request $request)
    {
        $validatedData = $request->validate([
            'assigned_job_id' => 'required|exists:assigned_jobs,id',
        ]);

        $assignedJob = AssignedJobs::findOrFail($validatedData['assigned_job_id']);
        $assignedJob->delete();

        return response()->json([
            'message' => 'Job declined successfully'
        ]);
    }
}
