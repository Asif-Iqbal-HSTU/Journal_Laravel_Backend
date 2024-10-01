<?php

namespace App\Http\Controllers;
use App\Models\Myjob;

use Illuminate\Http\Request;

class MyjobController extends Controller
{
    public function index()
    {
        // Fetch all jobs from the myjobs table
        $myjobs = Myjob::all();

        // Return the jobs as JSON
        return response()->json($myjobs);
    }

    public function show($id)
    {
        // Fetch the job by ID
        $job = Myjob::find($id);

        // Check if the job exists
        if (!$job) {
            return response()->json([
                'message' => 'Job not found',
            ], 404);
        }

        // Return the job as a JSON response
        return response()->json($job);
    }

    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'salary' => 'required|string',
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        // Create and save the new job
        $job = Myjob::create($validatedData);

        // Return a success response
        return response()->json([
            'message' => 'Job added successfully',
            'job' => $job,
        ], 201);
    }

    // New function to update a job
    public function update(Request $request, $id)
    {
        // Validate the data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'salary' => 'required|string',
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        // Find the job by ID
        $job = Myjob::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        // Update the job with the validated data
        $job->update($validatedData);

        return response()->json([
            'message' => 'Job updated successfully',
            'job' => $job,
        ], 200);
    }

    // New function to delete a job
    public function destroy($id)
    {
        // Find the job by ID
        $job = Myjob::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        // Delete the job
        $job->delete();

        return response()->json([
            'message' => 'Job deleted successfully',
        ], 200);
    }
}
