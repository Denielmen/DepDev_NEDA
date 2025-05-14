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
        $programmedTrainings = Training::where('type', 'Program')
            ->where('status', '!=', 'Implemented')
            ->get();
        return view('userPanel.tracking', compact('programmedTrainings'));
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
                'competency' => $request->input('competency'),
                'provider' => $request->input('provider'),
                'type' => 'Unprogrammed',
                'status' => 'Implemented',
                'implementation_date' => $request->input('date_from'),
            ]);
        } else {
            $training = Training::find($request->input('courseTitle'));
            if ($training && $training->status !== 'Implemented') {
                $training->status = 'Implemented';
                $training->save();
            }
        }

        // Save uploaded files as TrainingMaterial with user as source
        if ($training && !empty($filePaths)) {
            foreach ($filePaths as $filePath) {
                TrainingMaterial::create([
                    'title'      => $training->title,
                    'competency' => $training->competency,
                    'source'     => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                    'file_path'  => $filePath,
                ]);
            }
        }

        return back()->with('success', 'Submission successful!');
    }
} 