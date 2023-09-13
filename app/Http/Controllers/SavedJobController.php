<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedJobs;
use App\Models\User;

class SavedJobController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,job_id',
        ]);

        $savedJob = SavedJobs::create($validatedData);

        return response()->json(['message' => 'Job saved successfully', 'data' => $savedJob], 201);
    }

    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $savedJobs = SavedJobs::where('user_id', $user_id)->get();

        return response()->json(['data' => $savedJobs]);
    }

    public function destroy($id)
    {
        $savedJob = SavedJobs::findOrFail($id);
        $savedJob->delete();

        return response()->json(['message' => 'Job removed from saved jobs']);
    }

    public function getSavedJobsPerUser(Request $request, User $user)
    {
        $savedJobs = $user->savedJobs()->with('job')->get();
        return response()->json($savedJobs, 200);
    }

}
