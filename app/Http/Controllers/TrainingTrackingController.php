<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingTrackingController extends Controller
{
    public function index()
    {
        // Fetch all programmed trainings that are not implemented
        $competencies = \App\Models\Competency::all();
        $programmedTrainings = Training::where('type', 'Program')
            ->where('status', '!=', 'Implemented')
            ->get();
        $participationTypes = \App\Models\ParticipationType::all();
        return view('userPanel.tracking', compact('programmedTrainings', 'competencies', 'participationTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'uploaded_file'   => 'nullable', // We'll handle validation for multiple files below
            'uploaded_file.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:51200', // 50MB max per file
            'web_url'         => 'nullable|url',
            'courseTitle'     => 'required',
            'other_training_title' => 'required_if:courseTitle,other',
            // Add other validations as needed
        ]);

        $filePaths = [];
        if ($request->hasFile('uploaded_file')) {
            foreach ($request->file('uploaded_file') as $file) {
                $filePaths[] = $file->store('uploads', [
                    'disk' => 'public',
                    'visibility' => 'public',
                ]);
            }
        }

        // Handle 'Others' selection
        if ($request->input('courseTitle') === 'other') {
            $training = Training::create([
                'title' => $request->input('other_training_title'),
                'competency_id' => $request->input('competency_id'),
                'provider' => $request->input('provider'),
                'no_of_hours' => $request->input('no_of_hours'),
                'budget' => $request->input('expenses'),
                'type' => 'Unprogrammed',
                'status' => 'Implemented',
                'implementation_date_from' => $request->input('implementation_date_from'),
                'implementation_date_to' => $request->input('implementation_date_to'),
                'user_id' => Auth::id(),
            ]);

            // Get the participation type ID from the request
            $participationTypeId = $request->input('participation_type_id');
            
            // Add the user as a participant with their selected role
            $training->participants()->attach(Auth::id(), [
                'participation_type_id' => $participationTypeId,
                'year' => date('Y')
            ]);

        } else {
            $training = Training::find($request->input('courseTitle'));
            if ($training && $training->status !== 'Implemented') {
                $training->status = 'Implemented';
                // Update implementation dates if provided
                if ($request->filled('date_from')) {
                    $training->implementation_date_from = $request->input('date_from');
                }
                if ($request->filled('date_to')) {
                    $training->implementation_date_to = $request->input('date_to');
                }
                $training->save();
            }
        }

        // Debug: Log the web_url value
        \Log::info('web_url:', [$request->web_url]);

        // Save a single TrainingMaterial record for file and/or link
        $filePath = null;
        if (!empty($filePaths)) {
            $filePath = $filePaths[0]; // Only the first file
        }
        $link = $request->filled('web_url') ? $request->web_url : null;

        if ($training && ($filePath || $link)) {
            TrainingMaterial::create([
                'title'         => $training->title,
                'competency_id' => $training->competency_id ?? $request->input('competency_id'),
                'user_id'       => Auth::id(), // <-- Add this line
                'source'        => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                'file_path'     => $filePath,
                'link'          => $link,
                'type'          => 'material',
            ]);
        }

        // Save uploaded certificates as TrainingMaterial with type 'certificate'
        if ($training && $request->hasFile('certificate_file')) {
            foreach ($request->file('certificate_file') as $file) {
                $certPath = $file->store('uploads', [
                    'disk' => 'public',
                    'visibility' => 'public',
                ]);
                TrainingMaterial::create([
                    'title'         => $training->title,
                    'competency_id' => $training->competency_id ?? null,
                    'user_id'       => Auth::id(), // <-- Add this line
                    'source'        => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                    'file_path'     => $certPath,
                    'link'          => null,
                    'type'          => 'certificate',
                ]);
            }
        }

        return back()->with('success', 'Submission successful!');
    }
}