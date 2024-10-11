<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'email' => 'required|email',
            'username' => 'required|string',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            'title' => 'required|string',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'classification' => 'required|array', // Expecting an array for multiple classifications
            'classification.*' => 'in:Category A,Category B,Category C', // Validating each item in the array
            'coAuthors' => 'array', // Optional, allow co-authors as an array
            'coAuthors.*.name' => 'nullable|string|max:255', // Each co-author's name
            'coAuthors.*.email' => 'nullable|email', // Each co-author's email
            'docFile' => 'required|file|mimes:doc,docx|max:2048',
            'pdfFile' => 'required|file|mimes:pdf|max:2048',
            'zipFile' => 'nullable|file|mimes:zip|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle file uploads
        $docPath = $request->file('docFile')->store('submissions/documents', 'public');
        $pdfPath = $request->file('pdfFile')->store('submissions/pdfs', 'public');
        $zipPath = $request->file('zipFile') ? $request->file('zipFile')->store('submissions/zips', 'public') : null;

        // Saving the form data
        // Assuming you have a Submission model, here you would save the submission details.
        // Example:
        // Submission::create([
        //     'type' => $request->type,
        //     'email' => $request->email,
        //     'username' => $request->username,
        //     'role' => $request->role,
        //     'title' => $request->title,
        //     'abstract' => $request->abstract,
        //     'keywords' => $request->keywords,
        //     'coAuthors' => $request->coAuthors,
        //     'doc_file' => $docPath,
        //     'pdf_file' => $pdfPath,
        //     'zip_file' => $zipPath,
        // ]);

        return response()->json(['message' => 'Submission successfully stored'], 200);
    }
}
