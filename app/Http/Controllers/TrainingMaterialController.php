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

        // Resolve file via the public storage disk
        $disk = \Illuminate\Support\Facades\Storage::disk('public');
        $relativePath = $trainingMaterial->file_path;

        if (!$disk->exists($relativePath)) {
            return back()->with('error', 'File not found.');
        }

        $mime = null;
        try {
            $mime = $disk->mimeType($relativePath);
        } catch (\Throwable $e) {
            $mime = 'application/octet-stream';
        }

        $filename = basename($relativePath);

        // Stream the download with proper headers
        return $disk->download($relativePath, $filename, [
            'Content-Type' => $mime,
        ]);
    }
}
