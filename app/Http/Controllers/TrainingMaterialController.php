<?php

namespace App\Http\Controllers;

use App\Models\TrainingMaterial;
use Illuminate\Http\Request;

class TrainingMaterialController extends Controller
{
    // List and search training materials
    public function index(Request $request)
    {
        $search = $request->input('search');
        $trainingMaterials = TrainingMaterial::search($search)->get();
        return view('training_materials.index', compact('trainingMaterials', 'search'));
    }

    // Show a single training material
    public function show(TrainingMaterial $trainingMaterial)
    {
        return view('training_materials.show', compact('trainingMaterial'));
    }

    // Show the form to create a new training material
    public function create()
    {
        return view('training_materials.create');
    }

    // Store a new training material
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'competency_id.*' => 'exists:competencies,id',
            'user_id'=> 'required|exists:users,id',
            'source'        => 'nullable|string|max:255',
            'file_path'     => 'nullable|string|max:255',
            'link'          => 'nullable|url',
            'type'          => 'required|string|max:50',
        ]);
        TrainingMaterial::create($validated);
        return redirect()->route('training_materials.index')->with('success', 'Training material created!');
    }

    // Show the form to edit a training material
    public function edit(TrainingMaterial $trainingMaterial)
    {
        return view('training_materials.edit', compact('trainingMaterial'));
    }

    // Update a training material
    public function update(Request $request, TrainingMaterial $trainingMaterial)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'user_id'       => 'required|exists:users,id',
            'source'        => 'nullable|string|max:255',
            'file_path'     => 'nullable|string|max:255',
            'link'          => 'nullable|url',
            'type'          => 'required|string|max:50',
        ]);
        $trainingMaterial->update($validated);
        return redirect()->route('training_materials.index')->with('success', 'Training material updated!');
    }

    // Delete a training material
    public function destroy(TrainingMaterial $trainingMaterial)
    {
        $trainingMaterial->delete();
        return redirect()->route('training_materials.index')->with('success', 'Training material deleted!');
    }

    // Download a training material file
    public function download(TrainingMaterial $trainingMaterial)
    {
        if (!$trainingMaterial->file_path) {
            return back()->with('error', 'No file available for download.');
        }

        // Check if the file exists in the current year's directory
        $currentYear = date('Y');
        $filePath = storage_path('app/public/' . $trainingMaterial->file_path);
        
        // If file doesn't exist, check if it's in a previous year's directory
        if (!file_exists($filePath)) {
            // Extract the filename from the path
            $filename = basename($trainingMaterial->file_path);
            
            // Check previous years (up to 5 years back)
            for ($year = $currentYear - 1; $year >= $currentYear - 5; $year--) {
                $yearPath = str_replace("/$currentYear/", "/$year/", $trainingMaterial->file_path);
                $testPath = storage_path('app/public/' . $yearPath);
                
                if (file_exists($testPath)) {
                    $filePath = $testPath;
                    break;
                }
            }
            
            // If still not found, return error
            if (!file_exists($filePath)) {
                return back()->with('error', 'File not found. Please contact support if this issue persists.');
            }
        }

        $headers = [
            'Content-Type' => mime_content_type($filePath),
            'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        return response()->download($filePath, basename($filePath), $headers);
    }
}
