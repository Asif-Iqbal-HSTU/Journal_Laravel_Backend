<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Paper;
use App\Models\CoAuthor;
use App\Models\Paperstatus;
use App\Models\Classification;
use Illuminate\Support\Str;

class PaperController extends Controller
{    
    public function store(Request $request)
    {
        $randomPaperID = 'PAPER_' . Str::random(10);
        // Handle file uploads without validation
        $editableFilePath = $this->uploadFile($request, $randomPaperID, 'docFile', 'public/editable');
        $pdfFilePath = $this->uploadFile($request, $randomPaperID, 'pdfFile', 'public/pdf');
        $imageFilePath = $this->uploadFile($request, $randomPaperID, 'zipFile', 'public/imageZip'); // Optional
        \Log::info('Editable File Path: ' . $editableFilePath);
        \Log::info('PDF File Path: ' . $pdfFilePath);
        \Log::info('Image File Path: ' . $imageFilePath);
        \Log::info('Co Authors: ' . $request->coAuthors);
        // \Log::info('Session :): ' . session()->all());
        // Log::info('Current session data:', session()->all());

        //$dd($request);
        // Create a new paper entry directly from the request
        $paper = Paper::create([
            'paperID' => $randomPaperID,
            'user_id' => $request->user_id,
            'type' => $request->type,
            'classification' => $request->classification,
            'language_option' => $request->language_option,
            'comments' => $request->comments,
            'title' => $request->title,
            'abstract' => $request->abstract,
            'keywords' => $request->keywords,
            'funding' => $request->funding,
            'conflictsOfInterest' => $request->conflictsOfInterest,
            'ethicalStatement' => $request->ethicalStatement,
            'consentToPolicies' => $request->consentToPolicies,
            'docFile' => $editableFilePath,
            'pdfFile' => $pdfFilePath,
            'zipFile' => $imageFilePath,
        ]);

        // Optionally, create a related status entry
        Paperstatus::create([
            'paper_id' => $paper->id,
            'status' => 'Pending',
        ]);

        // Handle co-authors
        $coAuthors = json_decode($request->coAuthors, true);
        
        if ($coAuthors) {
            foreach ($coAuthors as $coAuthor) {
                CoAuthor::create([
                    'paper_id' => $paper->id,
                    'name' => $coAuthor['name'],
                    'email' => $coAuthor['email'],
                ]);
            }
        }

        // Return a success response
        return response()->json([
            // 'message' => 'Paper created successfully!',
            'message' => $request,
        ], 201);
    }

    private function uploadFile(Request $request, string $randomPaperID, string $fileKey, string $directory): string
    {
        if ($request->hasFile($fileKey)) {
            $fileName = $randomPaperID . '_' . $request->file($fileKey)->getClientOriginalName();
            $filePath = $request->file($fileKey)->storeAs($directory, $fileName, 'public'); // Explicitly use 'public' disk
            return $filePath;
        }

        return '';  // Return an empty string if no file is uploaded
    }

    public function getAllPapers()
    {
        $papers = Paper::all();

        return response()->json(
            [
                'papers' => $papers,
            ],
            201
        );
    }

    // public function getPapersOfCurrentUser($u_id)
    // {
    //     //\Log::info('Session Data:', session()->all());

    //     // $currUserID = session()->get('curr_user');
    //     // dd($currUserID);
    //     $papers = Paper::where('user_id', $u_id)->get();

    //     return response()->json(
    //         [
    //             'papers' => $papers,
    //         ],
    //         201
    //     );
    // }

    public function getPapersOfUser($user_id)
    {
        $papers = Paper::where('user_id', $user_id)->get();

        return response()->json($papers);
    }

    public function getPaperById($id)
    {
        $paper = Paper::find($id);
        if ($paper) {
            return response()->json($paper);
        } else {
            return response()->json(['message' => 'Paper not found'], 404);
        }
    }



}
